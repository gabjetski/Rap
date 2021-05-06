# Cheatsheet 
## ITP Projekt Rap

Hier sind sämtliche infos die nicht direkt im Code erkennbar sind. (z.B die verschiedenen Fehlercodes)

<br>
<br>

## Modules
Die verschiedenen Module für die die Permissions vergeben werden können und ihre Nummern.
<br>

### Zum verwenden der Permission:

require_once 'permissions.php';

### Zum checken, ob ein User Permission hat
permission(***User-Id***, ***Modul-Nummer***);  
--> returned ein boolean

### die Module:
| **Modul-Name** | **Modul-Nummer** |
|----------------|------------------|
|Download        |1                 |
|Upload          |2                 |
|LoginRegister   |3                 |
|adminEdit       |4                 |

<br>
<br>
 
## Fehlercodes