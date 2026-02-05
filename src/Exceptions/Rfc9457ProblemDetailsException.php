<?php

// Copyright (c) 2026-present Stuart Herbert
// All rights reserved.
//
// Redistribution and use in source and binary forms, with or without
// modification, are permitted provided that the following conditions
// are met:
//
//   * Re-distributions of source code must retain the above copyright
//     notice, this list of conditions and the following disclaimer.
//
//   * Redistributions in binary form must reproduce the above copyright
//     notice, this list of conditions and the following disclaimer in
//     the documentation and/or other materials provided with the
//     distribution.
//
//   * Neither the names of the copyright holders nor the names of his
//     contributors may be used to endorse or promote products derived
//     from this software without specific prior written permission.
//
// THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
// "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
// LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
// FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
// COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
// INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
// BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
// LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
// CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
// LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
// ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
// POSSIBILITY OF SUCH DAMAGE.

declare(strict_types=1);

namespace StuartHerbert\TypesafeCollections;

use Exception;
use Throwable;

/**
 * Rfc9457ProblemDetailsException is a PHP Exception that holds data that
 * follows the RFC 9457 standard.
 *
 * @see https://www.rfc-editor.org/rfc/rfc9457
 *
 * @phpstan-type ProblemReportExtraLeaf int|string|array<string,int|string>
 * @phpstan-type ProblemReportExtraNode int|string|array<string, ProblemReportExtraLeaf>
 * @phpstan-type ProblemReportExtra array<string, int|string|array<string,ProblemReportExtraNode>>
 */
class Rfc9457ProblemDetailsException extends Exception
{
    /**
     * @param non-empty-string $type
     * @param non-empty-string $title
     * @param ProblemReportExtra $extra
     * @param non-empty-string|null $instance
     */
    public function __construct(
        protected string $type,
        protected int $status,
        protected string $title,
        protected string $detail = "",
        protected array $extra = [],
        protected ?string $instance = null,
        protected ?Throwable $previous = null,
    ) {
        parent::__construct(
            message: $title,
            previous: $previous,
        );
    }

    // ================================================================
    //
    // Getters
    //
    // ----------------------------------------------------------------

    /**
     * @phpstan-assert-if-true non-empty-string $this->getInstance()
     */
    public function hasInstance(): bool
    {
        return $this->instance !== null;
    }

    /**
     * @return non-empty-string|null
     */
    public function getInstance(): ?string
    {
        return $this->instance;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @phpstan-assert-if-true non-empty-string $this->getDetail()
     */
    public function hasDetail(): bool
    {
        return ! empty($this->detail);
    }

    public function getDetail(): string
    {
        return $this->detail;
    }

    public function hasExtra(): bool
    {
        return ! empty($this->extra);
    }

    /**
     * @return ProblemReportExtra
     */
    public function getExtra(): array
    {
        return $this->extra;
    }
}
