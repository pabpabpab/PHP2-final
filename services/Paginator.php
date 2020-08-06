<?php

namespace App\services;


class Paginator extends Service
{
    protected $items = [];
    protected $baseUrl;
    protected $quantityPerPage;
    protected $repository;
    protected $userId;
    public $pageNumber;


    public function setItems($params)
    {
        $this->pageNumber = $params['pageNumber'];
        $this->baseUrl = $params['baseUrl'];
        $this->quantityPerPage = $params['quantityPerPage'];

        $repositoryName = $params['entityName'] . 'Repository';
        $this->repository = $this->container->$repositoryName;

        $this->userId = $params['userId'];


        if ($params['userId'] > 0) {
            $this->items = $this->repository->getAllByPageWithUserId($params['pageNumber'], $params['quantityPerPage'], $params['userId']);
        } else {
            $this->items = $this->repository->getAllByPage($params['pageNumber'], $params['quantityPerPage']);
        }
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function getUrls()
    {
        if ($this->userId > 0) {
            $pagesQuantity = $this->repository->getPagesQuantityByUserId($this->quantityPerPage, $this->userId);
        } else {
            $pagesQuantity = $this->repository->getPagesQuantity($this->quantityPerPage);
        }

        $urls = [];
        for ($i = 1; $i <= $pagesQuantity; $i++) {
            $urls[$i] = $this->baseUrl . '?page=' . $i;
        }

        return $urls;
    }
}
