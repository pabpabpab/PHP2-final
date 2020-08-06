<?php


namespace App\services;


class Cart extends Service
{
    public array $goods = [];
    public int $count = 0;
    public int $totalPrice = 0;


    public function init()
    {
        if (is_array($this->session('goods'))) {
            $this->goods = $this->session('goods');
        }

        $this->count = $this->getCount();
        $this->totalPrice = $this->getTotalPrice();

        return $this;
    }

    public function add($id)
    {
        $this->init();

        if (!($this->isGoodExists($id))) {
            return false;
        }

        $good = $this->container->goodRepository->getOne($id);

        if (!is_array($this->goods[$id])) {
            $this->goods[$id]['name'] = $good->name;
            $this->goods[$id]['price'] = $good->price;
            $this->goods[$id]['main_img_name'] = $good->main_img_name;
            $this->goods[$id]['img_folder'] = $good->img_folder;
            $this->goods[$id]['count'] = 1;
            $this->goods[$id]['totalPrice'] = $good->price;
        } else {
            $this->goods[$id]['count'] += 1;
            $this->goods[$id]['totalPrice'] = $this->goods[$id]['price'] * $this->goods[$id]['count'];
        }

        $this->refresh();
        return true;
    }

    public function delete($id)
    {
        if (empty($id)) {
            return false;
        }

        $this->init();

        if ($this->goods[$id]['count'] > 1) {
            $this->goods[$id]['count'] -= 1;
            $this->goods[$id]['totalPrice'] = $this->goods[$id]['price'] * $this->goods[$id]['count'];
        } else {
            unset($this->goods[$id]);
        }

        $this->refresh();
        return true;
    }

    public function save($goodsCount)
    {
        $this->init();

        foreach ($goodsCount as $id=>$count) {
            if (!($this->isGoodExists($id))) {
                return false;
            }
            if (empty((int) $count)) {
                unset($this->goods[$id]);
                continue;
            }
            $this->goods[$id]['count'] = $count;
            $this->goods[$id]['totalPrice'] = $this->goods[$id]['price'] * $this->goods[$id]['count'];
        }

        $this->refresh();
        return true;
    }

    protected function refresh()
    {
        $this->count = $this->getCount();
        $this->totalPrice = $this->getTotalPrice();
        $this->setSession();
    }

    protected function getTotalPrice()
    {
        $total = 0;
        foreach ($this->goods as $good) {
            $total += $good['count'] * $good['price'];
        }
        $total = number_format($total, 2, '.', '');
        return $total;
    }

    protected function getCount()
    {
        $count = 0;
        foreach ($this->goods as $good) {
            $count += $good['count'];
        }
        return $count;
    }

    protected function isGoodExists($id)
    {
        return $this->container->goodRepository->isExists($id);
    }

    protected function setSession()
    {
        $this->container->request->setSession('goods', $this->goods);
        $this->container->request->setSession('cartCount', $this->getCount());
    }

    public function resetCart()
    {
        $this->container->request->setSession('goods', []);
        $this->container->request->setSession('cartCount', 0);
    }

    protected function session($key)
    {
        return $this->container->request->session($key);
    }
}