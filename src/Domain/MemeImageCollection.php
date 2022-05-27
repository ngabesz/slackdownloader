<?php


namespace Domain;

use ArrayAccess;
use ArrayIterator;
use IteratorAggregate;

final class MemeImageCollection implements ArrayAccess, IteratorAggregate, \Countable {

  private $images;


  public function __construct(MemeImage ...$Images) {
    $this->images = $Images;
  }

  public function offsetExists($offset) : bool {
    return isset($this->images[$offset]);
  }

  public function offsetGet($offset) : MemeImage {
    return $this->images[$offset];
  }

  public function offsetSet($offset,$value) : void {

    if ($value instanceof MemeImage) {
      if (is_null($offset)) {
        $this->images[] = $value;
      } else {
        $this->images[$offset] = $value;
      }
    }
    else throw new \TypeError("Not a MemeImage!");
  }

  public function offsetUnset($offset) : void {
    unset($this->images[$offset]);
  }

  public function getIterator() : ArrayIterator {
    return new ArrayIterator($this->images);
  }

  public function count()
  {
    return count($this->images);
  }

  public function merge(MemeImageCollection $collection )
  {
    foreach ($collection as $c){
      $this->images[] = $c;
    }
  }
}
