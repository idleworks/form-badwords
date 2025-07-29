# EXT:form badwords validator

Adds a validator to TYPO3's form framework that checks user input against a list of bad words.
An example list is bundled with this package, but it can be customized as needed.

This feature was originally developed to detect bad words submitted through contact forms. However, it can also be used to block certain email addresses, domain parts (e.g., junk mail providers), or known disruptive users.

## Installation

`composer require idleworks/form-badwords`

The required TypoScript is automatically included in your setup.

## Configuration

### Add the validator to form fields
Each form field you want to validate must be equipped with the new Badwords validator.
You can configure this in the Form Manager within the TYPO3 backend.

### Customize badwords file

This extension comes with an example bad words list. You can customize it to suit your specific needs.
To do this, update the path to the badwords file in the extension configuration using the Install Tool.

> Important:
>
> If you place the badwords file in a publicly accessible directory (e.g., fileadmin), it may be indexed by search engines — which is likely not desirable. Therefore, make sure to protect the file using an .htaccess rule or equivalent server configuration.

You can use regular expressions to tune your badwords list.
Comments starting with a hash (#) are also possible and are excluded from processing.

#### Examples

    # Matches word parts (e.g. "send nudes")
    nude
    # Matches only the word "nude"
    \b(nude)\b
    # Matches all email address of mailinator.com
    @mailinator\.com$
