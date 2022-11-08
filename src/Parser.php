<?php

declare(strict_types=1);

namespace Majkel\Pseudokod;

class Parser
{
    public function __construct(
        public readonly TokenStream $tokens
    ) {
    }

    public function parseAlgorithm(): Nodes\AlgorithmNode
    {
        static $expect = [
            TokenKind::Algorithm,
            TokenKind::Space,
            TokenKind::Name,
        ];

        foreach ($expect as $token) {
            if ($token !== $this->tokens->next()->kind) {
                throw new \ParseError('Expected '.$token->value().', '.$this->tokens->curent()->kind->value().' given');
            }
        }
        $name = $this->tokens->curent();
        ['in' => $in, 'out' => $out] = $this->parseArguments();

        if (TokenKind::CurlyOpen !== $this->tokens->nextNonWhite()->kind) {
            throw new \ParseError('Expected {');
        }
        $this->tokens->nextNonWhite();
        $code = $this->parseBlock();

        return new Nodes\AlgorithmNode(
            $name->content,
            $in ? new Nodes\InputNode($in) : null,
            $out ? new Nodes\OutputNode($out) : null,
            $code
        );
    }

    /**
     * @return array{array<Nodes\VariableNode>, array<Nodes\VariableNode>}
     */
    public function parseArguments(): array
    {
        if (TokenKind::Open !== $this->tokens->nextNonWhite()->kind) {
            throw new \ParseError('Expected (, '.$this->tokens->curent()->kind->value().' given');
        }

        $result = [
            'in' => [],
            'out' => [],
        ];
        $mode = null;
        while (TokenKind::Close !== $this->tokens->nextNonWhite()->kind) {
            switch ($this->tokens->curent()->kind) {
                case TokenKind::In:
                    $mode = 'in';
                    if (TokenKind::Colon !== $this->tokens->next()->kind) {
                        throw new \ParseError('Expected :, '.$this->tokens->curent()->kind->value().'given');
                    }

                    break;

                case TokenKind::Out:
                    $mode = 'out';
                    if (TokenKind::Colon !== $this->tokens->next()->kind) {
                        throw new \ParseError('Expected :, '.$this->tokens->curent()->kind->value().'given');
                    }

                    break;

                case TokenKind::Name:
                    if (!$mode) {
                        throw new \ParseError('Unexpected variable, its not clear if its input/output');
                    }
                    $result[$mode][] = new Nodes\VariableNode($this->tokens->curent()->content);

                    break;

                case TokenKind::Comma:
                    break;

                default:
                    throw new \ParseError('Unexpected token');
            }
        }

        return $result;
    }

    public function parseStatement(): null|object
    {
        return
            $this->parseSet()
            ?? $this->parseSwap()
            ?? $this->parseIf()
            ?? $this->parseWhile()
            ?? $this->parseFor()
            ?? $this->parseUnary()
            ?? (
                ($ex = $this->parseExpression()) 
                ? new Nodes\StatementExpressionNode($ex)
                : new Nodes\NewLineNode()
            ) 
        ;
    }

    public function parseBlock(): Nodes\BlockNode
    {
        $result = [];
        while (TokenKind::CurlyClose !== $this->tokens->peekNonWhite()->kind) {
            $result[] = $this->parseStatement();
        }
        $this->tokens->nextNonWhite();

        return new Nodes\BlockNode($result);
    }

    public function parseExpression($end = TokenKind::NewLine): null|Nodes\ExpressionNode
    {
        $numbers = new Stack();
        $operators = new Stack();
        while ($this->tokens->nextNonWhite()->kind !== $end) {
            switch ($this->tokens->curent()->kind) {
                case TokenKind::Number:
                    $numbers->push(new Nodes\NumberNode($this->tokens->curent()->content));

                    break;

                case TokenKind::Compare:
                case TokenKind::Math:
                    $operator = $this->tokens->curent()->content;
                    if (in_array($operators->top(), ['/', '*'])) {
                        self::infix($numbers, $operator, Nodes\MathNode::class);
                    }
                    // at this point, I have no idea whats going on
                    if (in_array($operator, ['<', '>', '<=', '>=', '==', '!='])) {
                        if (in_array($operators->top(), ['/', '*', '+', '-'])) {
                            self::infix($numbers, $operators->pop(), Nodes\CompareNode::class);
                        }
                    }
                    $operators->push($operator);

                    break;

                case TokenKind::Open:
                    $operators->push('(');

                    break;

                case TokenKind::Close:
                    $group = [];
                    while (($operator = $operators->pop()) !== '(') {
                        if (is_null($operator)) {
                            throw new \ParseError('Unexpected )');
                        }

                        if (',' === $operator) {
                            $group[] = $numbers->pop();

                            continue;
                        }
                        self::infix($numbers, $operator, Nodes\MathNode::class);
                    }
                    $group[] = $numbers->pop();
                    $numbers->push(
                        $numbers->top() instanceof Nodes\VariableNode
                        ? new Nodes\FunctionNode($numbers->pop()->name, array_reverse($group))
                        : $group[0]
                    );

                    break;

                case TokenKind::Name:
                    $numbers->push($this->parseVariable());

                    break;

                case TokenKind::Comma:
                    $operators->push(',');

                    break;

                default:
                    print_r($this->tokens->curent());

                    throw new \ParseError('Unexpected token');
            }
        }

        while (($operator = $operators->pop()) !== null) {
            if (!in_array($operator, ['+', '-', '*', '/', '<', '>', '<=', '>=', '==', '!='])) {
                throw new \ParseError('Unexpected token');
            }
            self::infix($numbers, $operator, Nodes\MathNode::class);
        }

        return $numbers->top();
    }

    public function parseVariable(): Nodes\VariableNode
    {
        if (TokenKind::Name !== $this->tokens->curent()->kind) {
            throw new \ParseError('Expected variable');
        }

        $array_access = null;
        $name = $this->tokens->curent()->content;
        if (TokenKind::SquareOpen === $this->tokens->peekNonWhite()->kind) {
            $this->tokens->nextNonWhite();
            $array_access = $this->parseExpression(TokenKind::SquareClose);
        }

        return new Nodes\VariableNode($name, $array_access);
    }

    public function parseSet(): null|Nodes\SetNode
    {
        if (TokenKind::Name !== $this->tokens->peekNonWhite()->kind) {
            return null;
        }

        $pointer = $this->tokens->pointer;
        $this->tokens->nextNonWhite();
        $variable = $this->parseVariable();
        if (TokenKind::Set !== $this->tokens->peekNonWhite()->kind) {
            $this->tokens->pointer = $pointer;

            return null;
        }
        $this->tokens->nextNonWhite();
        $expression = $this->parseExpression();

        return new Nodes\SetNode($variable, $expression);
    }

    public function parseSwap(): null|Nodes\SwapNode
    {
        if (TokenKind::Name !== $this->tokens->peekNonWhite()->kind) {
            return null;
        }

        $pointer = $this->tokens->pointer;
        $this->tokens->nextNonWhite();
        $variable = $this->parseVariable();
        if (TokenKind::Swap !== $this->tokens->peekNonWhite()->kind) {
            $this->tokens->pointer = $pointer;

            return null;
        }
        $this->tokens->nextNonWhite(3);
        $swap = $this->parseVariable();
        $this->tokens->nextNonWhite();

        return new Nodes\SwapNode($variable, $swap);
    }

    public function parseIf($with_else = true): null|Nodes\IfNode
    {
        if (TokenKind::If !== $this->tokens->peekNonWhite()->kind) {
            return null;
        }

        $this->tokens->nextNonWhite();
        if (TokenKind::Open !== $this->tokens->nextNonWhite()->kind) {
            throw new \ParseError('Expected ( after if');
        }

        $condition = $this->parseExpression(TokenKind::Close);
        $code = $this->parseBody();

        $else_ifs = [];
        $else = null;

        if ($with_else) {
            while (TokenKind::Else == $this->tokens->curent()->kind) {
                if ($else_if = $this->parseIf(false)) {
                    $else_ifs[] = $else_if;
                } else {
                    if (!empty($else)) {
                        throw new \ParseError('If can have only 1 else');
                    }
                    $else = $this->parseBody();
                }
            }
        }

        return new Nodes\IfNode($condition, $code, $else_ifs, $else);
    }

    public function parseWhile(): null|Nodes\WhileNode
    {
        if (TokenKind::While !== $this->tokens->peekNonWhite()->kind) {
            return null;
        }

        $this->tokens->nextNonWhite();
        if (TokenKind::Open !== $this->tokens->nextNonWhite()->kind) {
            throw new \ParseError('Expected ( after while');
        }

        $condition = $this->parseExpression(TokenKind::Close);
        $code = $this->parseBody();

        return new Nodes\WhileNode($condition, $code);
    }

    public function parseFor(): null|Nodes\ForNode
    {
        if (TokenKind::For !== $this->tokens->peekNonWhite()->kind) {
            return null;
        }

        static $expect = [
            TokenKind::For,
            TokenKind::Open,
            TokenKind::Name,
            TokenKind::Colon,
            TokenKind::Number,
            TokenKind::Range,
        ];

        $tokens = [];

        foreach ($expect as $token) {
            if ($token !== $this->tokens->nextNonWhite()->kind) {
                throw new \ParseError('Expected '.$token->value().', '.$this->tokens->curent()->kind->value().' given');
            }
            $tokens[] = $this->tokens->curent();
        }

        $expression = $this->parseExpression(TokenKind::Comma);

        $operator = $this->tokens->nextNonWhite();
        if (TokenKind::Math !== $operator->kind) {
            throw new \ParseError('Expected eta reduction');
        }

        $number = $this->tokens->nextNonWhite();
        if (TokenKind::Number === $number->kind) {
            if (TokenKind::Close != $this->tokens->nextNonWhite()) {
                throw new \ParseError('Expected )');
            }
            $number = new Nodes\NumberNode($number->content);
        } elseif (TokenKind::Close == $number->kind) {
            $number = null;
        } else {
            throw new \ParseError('Expected )');
        }

        $body = $this->parseBody();

        return new Nodes\ForNode(
            new Nodes\VariableNode($tokens[2]->content),
            new Nodes\NumberNode($tokens[4]->content),
            $expression,
            new Nodes\EtaReductionNode($operator->content, $number),
            $body
        );
    }

    public function parseUnary(): null|Nodes\UnaryNode
    {
        switch ($this->tokens->peekNonWhite()->kind) {
            case TokenKind::Unary:
                $op = $this->tokens->nextNonWhite()->content;
                if (!($var = $this->parseExpression()) instanceof Nodes\VariableNode) {
                    throw new \ParseError('Expected variable after unary');
                }

                return new Nodes\UnaryNode(
                    $op,
                    $var
                );

                break;

            case TokenKind::Name:
                // TODO
                return null;

            default:
                return null;
        }
    }

    public function parseBody(): Nodes\BlockNode
    {
        if (TokenKind::CurlyOpen === $this->tokens->peekNonWhite()->kind) {
            $this->tokens->nextNonWhite();
            if (TokenKind::NewLine === $this->tokens->peekNonWhite()->kind) {
                $this->tokens->nextNonWhite();
            }

            $code = $this->parseBlock();
            $this->tokens->nextNonWhite();

            return $code;
        }

        if (TokenKind::NewLine === $this->tokens->peekNonWhite()->kind) {
            $this->tokens->nextNonWhite();
        }

        return new Nodes\BlockNode([$this->parseStatement()]);
    }

    private static function infix(Stack $stack, string $operator, string $class): void
    {
        $second = $stack->pop() ?? throw new \ParseError('Unexpected '.$operator);
        $first = $stack->pop() ?? throw new \ParseError('Unexpected '.$operator);
        $stack->push(new $class(
            $first,
            $operator,
            $second,
        ));
    }
}
