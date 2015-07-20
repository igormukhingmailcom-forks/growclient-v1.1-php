<?php

namespace Grow\Client\Model;


/**
 * SGAFGRReferralAndDetection
 *
 * Object representing a SGAFGRReferralAndDetection
 *
 * @author Igor Mukhin <igor.mukhin@gmail.com>
 */
class SGAFGRReferralAndDetection extends BaseModel
{
    /**
     * @var string
     */
    protected $pdfData;

    /**
     * @param  string $filename Filename to save to
     */
    public function savePdf($filename)
    {
        return file_put_contents($filename, $this->getPdfData());
    }
}
