# language: pl

Potrzeba biznesowa: Przelew pieniędzy
  Scenariusz: przelew pieniędzy
    Gdy Klient Borys chce przelać pieniądze do Klienta Maćka 40 Euro
    Zakładając że Klient Borys jest w posiadaniu 50 Euro
    Wtedy powinno Klientowi Borysowi zostać zabrane z konta 40 Euro
    I powinno Klientowi Borysowi zostać na koncie 10 Euro
    I saldo Klienta Maćka powinno zwiększyć się o 40 Euro