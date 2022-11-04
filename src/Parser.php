<?php

namespace Majkel\Pseudokod;

use Majkel\Pseudokod\Nodes;
use ParseError;

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
                throw new ParseError('Expected '.$token->value().', '.$this->tokens->curent()->kind->value().' given');
            }
        }
        $name = $this->tokens->curent();
        ['in' => $in, 'out' => $out] = $this->parseArguments();
        
        if ($this->tokens->nextNonWhite()->kind !== TokenKind::CurlyOpen) {
            throw new ParseError('Expected {');
        }
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
        if ($this->tokens->nextNonWhite()->kind !== TokenKind::Open) {
            throw new ParseError('Expected (, '.$this->tokens->curent()->kind->value().' given');
        }

        $result = [
            'in' => [],
            'out' => [],
        ];
        $mode = null;
        while ($this->tokens->nextNonWhite()->kind !== TokenKind::Close) {
            switch ($this->tokens->curent()->kind) {
                case TokenKind::In:
                    $mode = 'in';
                    if ($this->tokens->next()->kind !== TokenKind::Colon) {
                        throw new ParseError('Expected :, '.$this->tokens->curent()->kind->value().'given');
                    }
                    break;
                case TokenKind::Out:
                    $mode = 'out';
                    if ($this->tokens->next()->kind !== TokenKind::Colon) {
                        throw new ParseError('Expected :, '.$this->tokens->curent()->kind->value().'given');
                    }
                    break;
                case TokenKind::Name:
                    if (!$mode) {
                        throw new ParseError('Unexpected variable, its not clear if its input/output');
                    }
                    $result[$mode][] = new Nodes\VariableNode($this->tokens->curent()->content);
                    break;
                case TokenKind::Comma:
                    break;
                default:
                    throw new ParseError('Unexpected token');
            }
        }

        return $result;
    }

    public function parseStatement()
    {

    }

    public function parseBlock()
    {
        $result = [];
        while ($this->tokens->next()->kind !== TokenKind::CurlyClose) {
            $result[] = $this->parseExpression(); 
        }
        return $result;
    }

    public function parseExpression($end = TokenKind::NewLine): Nodes\ExpressionNode
    {
        $numbers = new Stack();
        $operators = new Stack();
        while ($this->tokens->nextNonWhite()->kind !== $end) {
            switch ($this->tokens->curent()->kind) {
                case TokenKind::Number:
                    $numbers->push(new Nodes\NumberNode($this->tokens->curent()->content));
                    break;
                case TokenKind::Math:
                    $operator = $this->tokens->curent()->content;
                    if (in_array($operator, ['/', '*'])) {
                        $numbers->push(new Nodes\MathNode(
                            $numbers->pop() ?? throw new ParseError('Unexpected '.$operator),
                            $operators->pop() ?? throw new ParseError('Unexpected '.$operator),
                            $numbers->pop() ?? throw new ParseError('Unexpected '.$operator),
                        ));
                    }
                    $operators->push($operator);
                    break;
                case TokenKind::Open:
                    break;

            }
        }

        while (($operator = $operators->pop()) !== null) {
            $numbers->push(new Nodes\MathNode(
                $numbers->pop() ?? throw new ParseError('Unexpected '.$operator),
                $operator,
                $numbers->pop() ?? throw new ParseError('Unexpected '.$operator),
            ));
        }

        return $numbers->top();
    }
}
