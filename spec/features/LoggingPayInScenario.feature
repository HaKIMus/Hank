# language: pl

Potrzeba biznesowa: Zbieranie informacji o dokonanych wpłatnościach
  Scenariusz: Próba wpłacenia poprawnej kwoty
    Gdy Klient wpłaca 50 Euro
    Wtedy system powinien przechwycić informację o płatności
    I zapisać informację o próbie wpłaty przez Klienta 50 Euro

  Scenariusz: Próba wpłacenia niepoprawnej kwoty
    Gdy Klient wpłaca 0 Euro
    Wtedy system powinien przechwycić informację o płatności
    I zapisać informację o próbie wpłaty przez Klienta 0 Euro
    I wyświetlić stosowny komunikat