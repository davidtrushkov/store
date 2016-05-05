
var p = require('./');
var obj = {
    travel: {
        down: {
            a: [{
                path: 'to get here'
            }]
        }
    }
};
obj[Symbol()] = 'arat';
obj[Symbol()] = { name: 'nark' };
obj[Symbol('foo')] = 'foo';
p(obj);


var Purdy = require('./');
var circularObj = { };
circularObj.a = circularObj;
Purdy({
    integer: Date.now(),
    string: 'foo',
    anonymous: Purdy,
    defined: function Yes() {},
    nested: {hello: 'hapi'},
    error: new Error('bad'),
    null: null,
    undefined: undefined,
    regexp: new RegExp,
    falseBool: false,
    trueBool: true,
    emptyArr: [],
    circular: circularObj,
    date: new Date(),
    arrayWithVisibleIndex: [ 'one', 'two', 'three' ]
});
