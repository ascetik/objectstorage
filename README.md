# objectstorage

Self-made SplObjectStorage extension

The purpose of this package is to use a **SplObjectStorage** in an easier and faster way.
The native implementation of this class leads to some complications to access to its content.

I tried to use the php DS package but came back to the enhancement of this present tool.

## Release notes

> version 0.3.0

- Offset read/write access

## Implementations

### Box

A **Box** uses a **SplObjectStorage** to store objects.
It provides easy ways to add content at the top or the bottom of the container, retrieve or remove some content.

Methods available :

- **Box**::associate(_object_, _mixed_, _?int_): _void_ - add or replace the offset of given object
- **Box**::clear(): _void_ - remove all content
- **Box**::contains(_object_): _bool_ - Check the existence of an instance (strict comparison)
- **Box**::count(): _int_ - return the number of items
- **Box**::each(_Closure_): _void_ - call given closure for avery items
- **Box**::filter(_Closure_): _self_ - return a new Box with elements filtered by Closure
- **Box**::find(_Closure_): _?object_ - find an element matching closure result
- **Box**::first(): _?object_ - Return the first stored element
- **Box**::getIterator(): SplObjectStorage - Return Box iterator
- **Box**::hasAny(_object_): _bool_ - Check the existence of an instance (value comparison)
- **Box**::isEmpty(): _bool_ - check if Box is empty
- **Box**::last(): _?object_ - Return the last stored element
- **Box**::map(_Closure_): _self_ - return a new Box containing instances returned by Closure
- **Box**::pop(): _?object_ - Remove and return the last element
- **Box**::push(_object_, _mixed_): _void_ - add content at the top of the storage
- **Box**::readonly(): _ReadonlyBox_ - return a readonly Box
- **Box**::remove(_Closure_): _bool_ - Remove filtered element if any and return true on success, false otherwise
- **Box**::sort(_callable_, _?BoxSortOrder_): _void_ - sort the box using given algorithm, ASC default order
- **Box**::sortReverse(_callable_): _void_ - sort the box using given algorithm, DESC order
- **Box**::shift(): _?object_ - Remove and return the first element
- **Box**::unshift(_object_, _mixed_): _void_ - add content at the tail of the storage
- **Box**::valueOf(_object_): _mixed_ - get the offset associated to the given object if present, null otherwise

### ReadonlyBox

A **ReadonlyBox** is, as the name suggests, a **Box** in readonly mode. It just provides read methods.

Methods available :

- **Box**::contains(_object_): _bool_ - Check the existence of an instance (strict comparison)
- **Box**::count(): _int_ - return the number of items
- **Box**::find(_Closure_): _?object_ - find an element matching closure result
- **Box**::each(_Closure_): _void_ - call given closure for avery items
- **Box**::first(): _?object_ - Return the first stored element
- **Box**::getIterator(): SplObjectStorage - Return Box iterator
- **Box**::hasAny(_object_): _bool_ - Check the existence of an instance (value comparison)
- **Box**::isEmpty(): _bool_ - check if Box is empty
- **Box**::last(): _?object_ - Return the last stored element
- **Box**::map(_Closure_): _self_ - return a new Box containing instances returned by Closure
- **Box**::valueOf(_object_): _mixed_ - get the offset associated to the given object if present, null otherwise

## Sorting

A **Box** is sortable but needs an algorithm to work with the instances registered by the Box.

This algorithm takes 2 arguments : The current Box value and the next one.
It returns an integer as the result of the comparison between those values, just like _usort()_ with instances.

## Offset access

The box instance provides methods to access the offset of all its content.

Methods _push_ and _unshift_ accept a first parameter that is the object to store, and a second nullable parameter for the offset.
However, it is still possible to add or change the offset of a value during runtime by using the _associate_ method.

It accepts 3 parameters :

- the object that MAY be registered by the Box
- the value to add/modify/remove as offset
- an optionnal boolean value, default set to false, to force pushing given object and associated offset in the Box :

```php
$box = new Box();
$class1 = new MyClass(1);
$class2 = new MyClass(2);
$class3 = new MyClass(3);
$box->push($class2, 'offset2'); // registering class2 with an offset as Box head
$box->unshift($class1, 'offset1'); // registering class2 with an offset as Box tail

$box->associate($class1, 'new offset'); // changing class1 offset

$box->associate($class2, null); // removing class2 offset

$box->associate($class3, 'offset3', $box::IGNORE_ON_MISSING); // $class3 not registered, no action (default behavior)

$box->associate($class3, 'offset3', $box::APPEND_ON_MISSING); // $class3 pushed in Box with its offset

$box->associate($class4, 'offset4', $box::PREPEND_ON_MISSING); // $class4 added as Box tail with its offset

```

> The _associate_ method is not available with **ReadonlyBox**.

To retrieve the offset of a registered object :

```php
// from last example
$offset1 = $box->valueOf($class1); // 'new offset' 

$offset2 = $box->valueOf($class2); // null 

$offset3 = $box->valueOf(new MyClass(4)); // null, unregistered object

```
