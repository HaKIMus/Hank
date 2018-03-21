# language: pl

Potrzeba biznesowa: Wypłacanie pieniędzy
  Scenariusz: wypłacanie pieniędzy
    Gdy Klient chce wypłacić 30 euro z konta
    Zakładając że klient ma taką sumę pieniędzy
    Wtedy powinno Klientowi zostać zabrane z konta 30 euro
    I jego saldo powinno wynosić 0 euro
    Jeśli Klient nie ma takiej sumy
    Wtedy Klient powinien dostać informacje o potwierdzeniu akcji
    Jeśli Klient potwierdził akcje
    Wtedy powinno Klientowi zostać zabrane z konta 30 euro
    Jeśli Saldo klienta po transkacji okaże się niższe niż -100 euro
    Wtedy analuj transkacje