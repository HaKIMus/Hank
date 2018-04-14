# language: pl

Potrzeba biznesowa: Wysyłanie pieniędzy do innego klienta
  Scenariusz: Próba wysłania pieniędzy
    Zakładając że Klient_1 ma 150 Euro na koncie
    Gdy Klient_1 prześle 50 Euro do Klienta_2
    Wtedy saldo konta Klienta_2 wzrośnie o 50 Euro
    Oraz saldo Klient_1 zmaleje o 50 Euro
    I saldo Klient_1 wyniesie 100 Euro