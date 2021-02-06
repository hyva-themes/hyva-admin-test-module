<?php declare(strict_types=1);

namespace Hyva\AdminTest\Model;

use Hyva\Admin\Api\HyvaGridArrayProviderInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem\Io\FileFactory;

class LogFileListProvider implements HyvaGridArrayProviderInterface
{
    private $directoryList;

    private $fileFactory;

    public function __construct(DirectoryList $directoryList, FileFactory $fileFactory)
    {
        $this->directoryList = $directoryList;
        $this->fileFactory = $fileFactory;
    }

    public function getHyvaGridData(): array
    {
        $file = $this->fileFactory->create();
        $file->cd($this->directoryList->getPath(DirectoryList::LOG));

        return $file->ls();
    }
}
