<?php

namespace Idleworks\FormBadwords\Service;

use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Idleworks\FormBadwords\Configuration;

class BadwordsProvider
{
    private string $badWordsRegExp = '';

    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly Configuration $configuration
    ) {
        try {
            if (str_starts_with($this->configuration->get('badwordsFile'), 'EXT:')) {
                $file = GeneralUtility::getFileAbsFileName($this->configuration->get('badwordsFile'));
                $lines = file($file);
            } else {
                $resourceFactory = GeneralUtility::makeInstance(ResourceFactory::class);
                $file = $resourceFactory->getFileObjectFromCombinedIdentifier($this->configuration->get('badwordsFile'));
                $content = $file->getContents();
                $lines = preg_split("/\r\n|\n|\r/", $content);
            }
            if (!empty($lines)) {
                foreach ($lines as $line) {
                    if (str_starts_with('#', (string)$line)) {
                        continue;
                    }
                    $this->badWordsRegExp .= trim((string)$line) . '|';
                }
                $this->badWordsRegExp = '/' . substr($this->badWordsRegExp, 0, -1) . '/i';
            }
        } catch (\Exception $e) {
            $this->logger->log(LogLevel::WARNING, 'Badwords validator for EXT:form could not read file containing badwords.', [
                'badwordsFile' => $this->configuration->get('badwordsFile'),
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function test(string $value): bool
    {
        if (empty($this->badWordsRegExp)) {
            return false;
        }
        return (bool)preg_match($this->badWordsRegExp, '-> ' . $value . '<-');
    }
}
