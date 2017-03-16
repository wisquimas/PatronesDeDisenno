var MySingleton = (function () {
    var instance;

    function init() {
        var privateNumber = Math.round(Math.random() * 1000);

        function privateMethod() {
            console.log('hola');
        }

        return {
            publicMethod: function () {
                privateMethod();
            },
            getRandomNumber: function () {
                return privateNumber;
            }
        };
    }

    return {
        getInstance: function () {
            if (!instance) {
                instance = init();
            }
            return instance;
        }
    }
})();
var Singleton = MySingleton.getInstance();
var Singleton2 = MySingleton.getInstance();

console.log(Singleton.getRandomNumber());
console.log(Singleton2.getRandomNumber());