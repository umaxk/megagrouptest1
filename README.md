# Тестовое для megagroup.ru

Написал вариант в лоб(index.php) и вариант с классом(IndexClass.php)

Как проверить?
Используйте любой контенер с php+nginx. 
[Например](https://hub.docker.com/r/edofede/nginx-php-fpm/) 

```
Дан CSV-файл с данными, которые описывают древовидную структуру. Первая строка файла описывает следующие столбцы: id, parent_id, name. Значения во всех последующих строках не содержат символов переносов строки.
Пример данных в CSV-файле:
id,parent_id,name
1,0,Электроника
7,2,Смартфоны
2,1,"Мобильные телефоны"
3,1,"Компьютеры и ноутбуки"
5,3,Ноутбуки
4,3,"Системные блоки"
9,5,Dell
8,5,HP
10,5,Lenovo
6,3,Комплектующие
Напишите скрипт на языке PHP, который конвертирует данные из CSV-файла в древовидный JSON-объект и выводит его на экран в читаемом для человека виде. Не используйте рекурсию.
Пример конечного результата:
{
  "1": {
    "name": "Электроника",
    "children": {
      "2": {
        "name": "Мобильные телефоны",
        "children": {
          "7": {
            "name": "Смартфоны"
          }
        }
      },
      "3": {
        "name": "Компьютеры и ноутбуки",
        "children": {
          "5": {
            "name": "Ноутбуки",
            "children": {
              "9": {
                "name": "Dell"
              },
              "8": {
                "name": "HP"
              },
              "5": {
                "name": "Lenovo"
              }
            }
          },
          "4": {
            "name": "Системные блоки"
          },
          "6": {
            "name": "Комплектующие"
          }
        }
      }
    }
  }
}
```
