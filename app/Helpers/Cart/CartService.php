<?php

namespace App\Helpers\Cart;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CartService
{
    protected $cart;

    public function __construct()
    {
        $this->cart = session()->get('cart') ?? collect([]);
    }


    /**
     * @param array $value
     * @param null $obj
     * @return $this
     */
    public function put(array $value , $obj = null)
    {
        if(!is_null($obj) && $obj instanceof Model){
            $value = array_merge($value,[
                'id' => Str::random(10),
                'subject_id' => $obj->id,
                'subject_type' => get_class($obj)
            ]);
        }elseif(! $value['id']){
            $value = array_merge($value,[
                'id' => Str::random(10)
            ]);
        }

        $this->cart->put($value['id'],$value);

        session()->put('cart',$this->cart);

        return $this;
    }

    public function has($key)
    {
        if($key instanceof Model){
            return !is_null($this->cart->where('subject_id',$key->id)->where('subject_type',get_class($key))->first());
        }

        return !is_null($this->cart->firstWhere('id',$key));
    }

    public function get($key, $withRelationship = true)
    {
        $item = $key instanceof Model
                    ? $this->cart->where('subject_id',$key->id)->where('subject_type',get_class($key))->first()
                    : $this->cart->firstWhere('id',$key);
        return $withRelationship ? $this->withRelationshipIfExist($item) : $item;
    }

    public function all()
    {
        $cart = $this->cart;

        $cart = $cart->map(function ($item){
            return $this->withRelationshipIfExist($item);
        });

        return $cart;
    }

    protected function withRelationshipIfExist(mixed $item)
    {
        if(isset($item['subject_id']) && isset($item['subject_type'])){

            $class = $item['subject_type'];
            $subject = (new $class())->find($item['subject_id']);

            unset($item['subject_id'],$item['subject_type']);

            $item[strtolower(class_basename($class))] = $subject;

            return $item;
        }

        return $item;
    }

    /**
     * @param $key
     * @param $options
     * @return $this
     */
    public function update($key, $options)
    {
        $item = collect($this->get($key,false));

        if(is_numeric($options)){
            $item = $item->merge([
                'quantity' => $item['quantity'] + $options
            ]);
        }

        if(is_array($options)){
            $item = $item->merge($options);
        }

        $this->put($item->toArray());

        return $this;
    }

    /**
     * @param $key
     * @return int|mixed
     */
    public function count($key)
    {
        if(! $this->has($key)) return 0;

        return $this->get($key)['quantity'];
    }
}
