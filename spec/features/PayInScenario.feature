# language: pl

Potrzeba biznesowa: Wpłacanie pieniędzy
  Scenariusz: wpłacanie pieniędzy
    Gdy Klient chce wpłacić 40 Euro
    Wtedy saldo Klienta powinno wzrosnąć o 40 Euro
    Jeśli Klient chce wpłacić sumę pieniędzy, która nie jest w walucie Euro
    Wtedy żądanie Klienta powinno zostać odrzucone