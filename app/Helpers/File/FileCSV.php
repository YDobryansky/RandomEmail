<?php
/**
 * Create: Volodymyr
 */

namespace App\Helpers\File;

use App\TDO\TaskImportSettingsDTO;

class FileCSV
{
    public function __construct(protected string $file)
    {
    }

    public function fileInformation(null|TaskImportSettingsDTO $prev_info = null, bool $reset = false): ?TaskImportSettingsDTO
    {
        if ($reset || !$prev_info || $prev_info->getFile() !== $this->getFile()) {
            $fields = $this->getHeader();
            $info = (new TaskImportSettingsDTO())
                ->setFile($this->getFile())
                ->setFileFields($fields)
                ->setFileFieldsSettings($prev_info?->getFileFieldsSettings());
        }

        return $info ?? $prev_info;
    }

    public function countLines(): int
    {
        $file = new \SplFileObject($this->getFile(), 'r');
        $file->setFlags(
            \SplFileObject::READ_AHEAD |
            \SplFileObject::SKIP_EMPTY |
            \SplFileObject::DROP_NEW_LINE
        );
        $file->seek(PHP_INT_MAX);
        $lines = $file->key();
        unset($file);
        return $lines;
    }

    /**
     * @return string
     */
    public function getFile(): string
    {
        return $this->file;
    }

    public function getHeader(): array
    {
        $file = new \SplFileObject($this->getFile(), 'r');
        $file->setFlags(
            \SplFileObject::READ_AHEAD
            | \SplFileObject::SKIP_EMPTY
            | \SplFileObject::DROP_NEW_LINE
            | \SplFileObject::READ_CSV
        );

        // get first file line
        $file_keys = $file->fgetcsv();
        if ($file_keys && !empty($file_keys[0])) {
            $file_keys[0] = static::removeBOM((string)$file_keys[0]);
        }

        unset($file);

        return $file_keys;
    }

    public static function removeBOM(string $str): string
    {
        return str_replace("\u{FEFF}", '', $str);
    }
}
