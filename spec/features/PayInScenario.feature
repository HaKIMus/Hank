# language: pl

Potrzeba biznesowa: Wpłacanie pieniędzy
  Scenariusz: wpłacanie pieniędzy
    Gdy Klient chce wpłacić 40 Euro
    Wtedy saldo Klienta powinno wzrosnąć o 40 Euro
    Jeśli Klient chce wpłacić sumę pieniędzy, która nie jest w walucie Euro
    Wtedy żądanie Klienta powinno zostać odrzucone
  Scenariusz: wpłacanie negatywnej sumy pieniędzy
    Gdy Klient chce wpłacić -40 Euro
    Wtedy powinień dostać ostrzeżenie o próbie wpłaty niepoprawnej sumie pieniędzy
  Scenariusz: wpłacanie za małej ilości pieniędzy
    Gdy Klient chce wpłacić 3 Euro
    Wtedy powinien dostać ostrzeżenie o próbie wpłaty za małej sumie pieniędzy
  Scenariusz: wpłacanie 0 pieniędzy
    Gdy Klient chce wpłacić 0 Euro
    Wtedy powinien dostać ostrzeżenie o braku sumy
  Scenariusz: wpłacanie za dużej ilości pieniędzy pieniędzy
    Gdy Klient chce wpłacić 10001 Euro
    Wtedy powinien dostać ostrzeżenie o próbie wpłaty za dużej ilości pieniędzy