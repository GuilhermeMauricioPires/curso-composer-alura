<?php

namespace Alura\BuscadorDeCursos;

use GuzzleHttp\ClientInterface;
use Symfony\Component\DomCrawler\Crawler;

class Buscador
{

    /** @var ClientInterface */
    private $httpClient;

    /** @var Crawler */
    private $crawler;

    /**
     * Buscador constructor.
     * @param ClientInterface $httpClient
     * @param Crawler $crawler
     */
    public function __construct(ClientInterface $httpClient, Crawler $crawler)
    {
        $this->httpClient = $httpClient;
        $this->crawler = $crawler;
    }

    public function buscar(string $url): array
    {
        $response = $this->httpClient->request('GET', $url, ['verify' => false]);
        $html = $response->getBody();
        $this->crawler->addHtmlContent($html);
        $cursos = [];
        $elementos = $this->crawler->filter('span.card-curso__nome');
        foreach ($elementos as $elemento) {
            $cursos[] = $elemento->textContent;
        }
        return $cursos;
    }
}
