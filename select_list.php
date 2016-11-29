<?php

$TEXT['clienti-pdf-select'] = "SELECT idcliente as 'ID Cliente',cognome as Cognome,nome as Nome,codicefiscale as 'C. FISC.'
		FROM clienti ORDER BY cognome";

$TEXT['parametri-pdf-select'] = "SELECT idparametro as 'ID Param.',nome as Nome,
		descrizione as Descrizione,valore as Valore 
		FROM parametri ORDER BY nome";

$TEXT['gruppi-pdf-select'] = "SELECT idgruppo as 'ID Gruppo',descrizione as 'Gruppo'
    FROM gruppi ORDER BY idgruppo";

$TEXT['ruoli-pdf-select'] = "SELECT idruolo as 'ID Ruolo',descrizione as 'Ruolo'
    FROM ruoli ORDER BY idruolo";

$TEXT['autorizzazioni-pdf-select'] = "SELECT idautorizzazione as 'ID Autor.',descrizione as 'Autorizzazione',
      operazione as 'Operazione', tabella as 'Tabella'
      FROM autorizzazioni ORDER BY idautorizzazione";

$TEXT['utenti-pdf-select'] = "SELECT idutente as 'ID Utente',username as 'Username',password as 'Password',
		cognome as Cognome,nome as Nome,email as Email,stato as Stato,modificatoda as 'Modif. da', datamodifica as 'Data Mod.'
		FROM utenti ORDER BY cognome,nome";

?>
