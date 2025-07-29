<?php

namespace Idleworks\FormBadwords\Mvc\Validation;

use Idleworks\FormBadwords\Service\BadwordsProvider;
use TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;

class BadwordsValidator extends AbstractValidator
{
    public function __construct(
        private readonly BadwordsProvider $badwordsProvider
    ) {
    }

    protected function isValid(mixed $value): void
    {
        if ($this->badwordsProvider->test($value)) {
            if ($this->result->hasErrors()) {
                return;
            }

            $this->addError(
                $this->translateErrorMessage(
                    'LLL:EXT:form_badwords/Resources/Private/Language/locallang.xlf:validator.badwords.notvalid',
                    'FormBadwords'
                ),
                1752497154
            );
        }
    }
}
