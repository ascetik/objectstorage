# objectstorage

Self-made SplObjectStorage extension

The purpose of this package is to use a **SplObjectStorage** in an easier and faster way.
The native implementation of this class leads to some complications to access to its content.

I tried to use the php DS package but came back to the enhancement of this present tool.

## Release notes

> version 0.2.0

- Sortable box : Ability to sort a box in ascending or descending order, using adapted callable.

## Implementations

### Box

A **Box** uses a **SplObjectStorage** to store objects.
It provides easy ways to add content at the top or the bottom of the container, retrieve or remove some content.

Methods available :

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

## Sorting

A **Box** is sortable but needs an algorithm to work with the instances registered by the Box.

This algorithm takes 2 arguments : The current Box value and the next one.
It returns an integer as the result of the comparison between those values, just like _usort()_ with instances.

## Next Features

The Box will be enhanced if needed.
It think i should do something to work easily with the offset of an element and be able to sort the box using those offsets...

I don't know if i'll do the same thing for other Spl Collection handlers : LinkedList, Queue...
Existing Spl implementation are too imprecise and inconsistent. But most of the time, **Box** seems to be enough for different operations.
