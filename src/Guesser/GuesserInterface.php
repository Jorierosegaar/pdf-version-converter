<?php

/*
 * This file is part of the PDF Version Converter.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Rosegaar\PDFVersionConverter\Guesser;

/**
 * Classes that implements this interface can guess the PDF version of given file.
 *
 */
interface GuesserInterface
{
    /**
     * Guess the PDF version of given file.
     *
     * @param string $file
     * @return string version (1.4, 1.5, 1.6) or null.
     * @throws \RuntimeException if version can't be guessed.
     */
    public function guess($file);
}
