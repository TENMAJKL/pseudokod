<?php

namespace Majkel\Pseudokod;

use ParseError;

enum TokenKind
{
    case Algorithm;
    case For;
    case Range;
    case Swap;
    case In;
    case Out;
    case If;
    case While;
    case Set;
    case Unary;
    case Math;
    case Logic;
    case Compare;
    case Colon;
    case Comma;
    case Semicolon;
    case NewLine;
    case Space;
    case Name;
    case Number;
    case Open;
    case Close;
    case CurlyOpen;
    case CurlyClose;
    case SquareOpen;
    case SquareClose;
    case Comment;

    public static function fromRe(string $re): self
    {
        return match ($re) {
            'ALGORITHM' => self::Algorithm,
            'FOR' => self::For,
            'RANGE' => self::Range,
            'SWAP' => self::Swap,
            'IN' => self::In,
            'OUT' => self::Out,
            'IF' => self::If,
            'WHILE' => self::While,
            'SET' => self::Set,
            'UNARY' => self::Unary,
            'MATH' => self::Math,
            'LOGIC' => self::Logic,
            'COMPARE' => self::Compare,
            'COLON' => self::Colon,
            'COMMA' => self::Comma,
            'SEMICOLON' => self::Semicolon,
            'NEWLINE' => self::NewLine,
            'SPACE' => self::Space,
            'NAME' => self::Name,
            'NUMBER' => self::Number,
            'OPEN' => self::Open,
            'CLOSE' => self::Close,
            'CURLY_OPEN' => self::CurlyOpen,
            'CURLY_CLOSE' => self::CurlyClose,
            'SQUARE_OPEN' => self::SquareOpen,
            'SQUARE_CLOSE' => self::SquareClose,
            'COMMENT' => self::Comment,
            'ERROR' => throw new ParseError('Unexpected token'),
        };
    }
    
    public function value(): string
    {
        return match ($this) {
            self::Algorithm => 'ALGORITHM',
            self::For => 'FOR',
            self::Range => 'RANGE',
            self::Swap => 'SWAP',
            self::In => 'IN',
            self::Out => 'OUT',
            self::If => 'IF',
            self::While => 'WHILE',
            self::Set => 'SET',
            self::Unary => 'UNARY',
            self::Math => 'MATH',
            self::Logic => 'LOGIC',
            self::Compare => 'COMPARE',
            self::Colon => 'COLON',
            self::Comma => 'COMMA',
            self::Semicolon => 'SEMICOLON',
            self::NewLine => 'NEWLINE',
            self::Space => 'SPACE',
            self::Name => 'NAME',
            self::Number => 'NUMBER',
            self::Open => 'OPEN',
            self::Close => 'CLOSE',
            self::CurlyOpen => 'CURLY_OPEN',
            self::CurlyClose => 'CURLY_CLOSE',
            self::SquareOpen => 'SQUARE_OPEN',
            self::SquareClose => 'SQUARE_CLOSE',
            self::Comment => 'COMMENT',
        };
    }
}
