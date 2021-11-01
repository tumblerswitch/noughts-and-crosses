# noughts-and-crosses
## Требования:

- Для проекта использовать [composer](https://getcomposer.org/). Инциализиовать с помощью него проект и реализовать autoload
- Возможность запускать игру с помощью `./bin/tictactoe`
- Игра для двоих. Ходы совершать поочередно (сначала ходит Х, потом О)
- Для вывода использовать библиотеку [php-cli-tools](https://github.com/wp-cli/php-cli-tools)
- Не использовать классы. Только функции
- Каждый ход обновлять таблицу с крестиками-ноликами
- Использовать [phpcs](https://github.com/squizlabs/PHP_CodeSniffer) для проверки кода. Стандарт - PSR12
    - `composer exec --verbose phpcs -- --standard=PSR12 <folder1> <folder2> ...`
- При завершении добавить в [README.md](http://README.md) запись [asciinema](https://asciinema.org/), чтобы увидеть как работает приложение