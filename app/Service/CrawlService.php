<?php


namespace App\Service;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use Spatie\Crawler\CrawlObserver;

class CrawlService extends CrawlObserver
{
    private $pages =[];
    public function willCrawl(UriInterface $uri) {
        echo "Now crawling: " . (string) $uri . PHP_EOL;
    }

    public function crawled(UriInterface $url, ResponseInterface $response, ?UriInterface $foundOnUrl = null)
    {
        $path = $url->getPath();
        $doc = new DOMDocument();
        @$doc->loadHTML($response->getBody());
        $title = $doc->getElementsByTagName("title")[0]->nodeValue;

        $this->pages[] = [
            'path'=>$path,
            'title'=> $title
        ];

        dd($this->pages);

        exit;
    }

    public function crawlFailed(UriInterface $url, RequestException $requestException, ?UriInterface $foundOnUrl = null)
    {
        echo 'failed';
    }
}
