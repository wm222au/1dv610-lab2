<?php
/**
 * Created by PhpStorm.
 * User: william
 * Date: 2018-10-21
 * Time: 16:15
 */

namespace View;


class FormView
{
    protected function generateFieldTooShortHTML(string $field, int $minLength): string
    {
        return $field . ' has too few characters, at least ' . $minLength . ' characters. ';
    }

    protected function generateFieldInvalidCharactersHTML(string $field): string
    {
        return $field . ' contains invalid characters. ';
    }

    protected function generateFieldIsEmptyHTML(string $field): string
    {
        return 'Username is missing';
    }

    protected function generateUnknownErrorHTML(): string
    {
        return 'An error occurred. Please try again.';
    }
}