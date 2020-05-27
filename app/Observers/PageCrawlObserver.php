<?php


namespace App\Observers;


use App\Page;
use DOMDocument;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use Spatie\Crawler\CrawlObserver;

class PageCrawlObserver extends CrawlObserver
{

    private $pages =[];

    public function willCrawl(UriInterface $uri) {
        echo PHP_EOL. "Now crawling: " . (string) $uri. ": ";
    }

    /**
     * Called when the crawler has crawled the given url successfully.
     *
     * @param \Psr\Http\Message\UriInterface $url
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param \Psr\Http\Message\UriInterface|null $foundOnUrl
     */
    public function crawled(UriInterface $url, ResponseInterface $response, ?UriInterface $foundOnUrl = null)
    {
        $path = $url->getPath();
        $doc = new DOMDocument();
        @$doc->loadHTML($response->getBody());
        if(is_object($doc->getElementsByTagName("title")[0])){
            $title = $doc->getElementsByTagName("title")[0]->nodeValue;
        }

        if(is_object($doc->getElementsByTagName("img")[0])){
            $img = $doc->getElementsByTagName("img")[0]->nodeValue;
        }


        $this->pages[] = [
            'path'=>$path,
            'title'=> $title ?? '',
            'data'=> $img ?? ''
        ];
        return $this->pages;
        exit;
    }

    /**
     * Called when the crawler had a problem crawling the given url.
     *
     * @param \Psr\Http\Message\UriInterface $url
     * @param \GuzzleHttp\Exception\RequestException $requestException
     * @param \Psr\Http\Message\UriInterface|null $foundOnUrl
     */
    public function crawlFailed(UriInterface $url, RequestException $requestException, ?UriInterface $foundOnUrl = null)
    {
        echo 'failed'.PHP_EOL;
    }

    public function finishedCrawling()
    {
        echo 'crawled ' . count($this->pages) . ' urls' . PHP_EOL;
        foreach ($this->pages as $page){
            echo sprintf("Url  path: %s Page title: %s%s", $page['path'], $page['title'], PHP_EOL);
            Page::create($page);
        }
    }
}
