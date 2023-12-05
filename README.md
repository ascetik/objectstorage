# objectstorage
Self-made SplObjectStorage extension


## Box

**Box**::clear(): *void*                    - remove all content
**Box**::contains(*object*): *bool*         - Check the existence of an instance (strict comparison)
**Box**::count(): *int*                     - return the number of items
**Box**::each(*Closure*): *void*            - call given closure for avery items
**Box**::filter(*Closure*): *self*          - return a new Box with elements filtered by Closure
**Box**::find(*Closure*): *?object*         - find an element matching closure result
**Box**::first(): *?object*                 - Return the first stored element
**Box**::getIterator(): SplObjectStorage    - Return Box iterator
**Box**::hasAny(*object*): *bool*           - Check the existence of an instance (value comparison)
**Box**::isEmpty(): *bool*                  - check if Box is empty
**Box**::last(): *?object*                  - Return the last stored element
**Box**::map(*Closure*): *self*             - return a new Box containing instances returned by Closure
**Box**::pop(): *?object*                   - Remove and return the last element
**Box**::push(*object*, *mixed*): *void*    - add content at the top of the storage
**Box**::readonly(): *ReadonlyBox*          - return a readonly Box
**Box**::remove(*Closure*): *bool*          - try to remove the element matching closure result. Return true if any removed, false otherwise
**Box**::shift(): *?object*                 - Remove and return the first element
**Box**::unshift(*object*, *mixed*): *void* - add content at the tail of the storage

## ReadonlyBox

**Box**::contains(*object*): *bool*         - Check the existence of an instance (strict comparison)
**Box**::find(*Closure*): *?object*         - find an element matching closure result
**Box**::each(*Closure*): *void*            - call given closure for avery items
**Box**::first(): *?object*                 - Return the first stored element
**Box**::getIterator(): SplObjectStorage    - Return Box iterator
**Box**::hasAny(*object*): *bool*           - Check the existence of an instance (value comparison)
**Box**::isEmpty(): *bool*                  - check if Box is empty
**Box**::last(): *?object*                  - Return the last stored element
**Box**::map(*Closure*): *self*             - return a new Box containing instances returned by Closure
