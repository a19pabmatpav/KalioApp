# **Nom del projecte: Kalio App**

## Integrants
- **Nom de l'integrant 1**: Pablo Matamoros

## Descripció
Aquesta aplicació web permet als usuaris registrar i gestionar el seu consum diari de calories, així com consultar informes detallats sobre la seva alimentació. L'usuari pot establir un **repte** personal amb un límit de calories diàries, el qual tindrà una durada determinada. Els usuaris podran registrar el consum de calories de cada dia i fer un seguiment del seu rendiment en relació amb el repte establert.

## Adreça del gestor de tasques
- [Taiga](https://tree.taiga.io/project/a19pabmatpav-tr3mini-mvpkalioapp/timeline)

## Adreça del prototip gràfic del projecte
- [Penpot](https://design.penpot.app/#/view?file-id=e3472dad-8d1d-80d6-8005-d3600318f8f0&page-id=e3472dad-8d1d-80d6-8005-d3600318f8f1&section=interactions&index=0&share-id=7e5a2fce-ccc0-804a-8005-d50a692b6a78) (Casus d'ús)

## URL de producció
- [kalioApp.com](kalioapp.a19pabmatpav.daw.inspedralbes.cat)

## Estat
El projecte es troba en fase de desenvolupament. Actualment, la funcionalitat de creació de reptes i registre de consum de calories diàries està implementada, i s'està treballant en la part de seguiment dels informes i validació de les dades. El sistema d'autenticació (login, registre d'usuaris) també està actiu i operatiu.

---

**Com instal·lar el projecte:**

1. **Clonar el repositori:**

   ```bash
   git clone https://github.com/usuari/projecte-calories.git
   ```

2. **Instal·lar dependències:**
   
   Per al backend (Laravel):
   ```bash
   composer install
   ```

   Per al frontend (Nuxt):
   ```bash
   npm install
   ```

3. **Configurar el `.env` per al backend:**

   Copia el fitxer `.env.example` a `.env` i ajusta la configuració de la base de dades, el correu electrònic, etc.

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Migrar les taules de la base de dades:**

   ```bash
   php artisan migrate
   ```

5. **Executar el servidor local (backend):**
   
   ```bash
   php artisan serve
   ```

6. **Executar el servidor local (frontend):**

   ```bash
   npm run dev
   ```

---

**Tecnologies utilitzades:**

- **Backend**: Laravel 11.x
- **Frontend**: Nuxt.js 1.x
- **Base de dades**: MySQL
- **Autenticació**: Sanctum
- **Frontend/Backend comunicats via API RESTful**

---

**Paleta de colors del projecte:**

- **Color principal 1**: `#2D1B52` (Color fosc per a fons i elements destacats)
- **Color secundari 1**: `#8A2BE2` (Color lila per a accents i interaccions)
- **Color destacat 1**: `#FF7A00` (Color taronja per a crides a l'acció)
- **Color secundari 2**: `#3C3145` (Color de fons i elements complementaris)

---

**Funcionalitats futures:**

- Crear informes detallats per als usuaris amb estadístiques sobre el seu consum de calories.
- Afegir notificacions per recordar als usuaris registrar el seu consum de calories diàries.
- Crear la funcionalitat de despeses de calories, conectant-se a bandes d'esport o d'altres.
- Integrar la detecció d'aliments mitjançant una fotografia i Gemini AI.
- Enviament d'emails amp l'històric demanat pel usuari.

---

**Més informació:**
Per a més detalls sobre el desenvolupament del projecte, consulteu la documentació del gestor de tasques i el prototip gràfic en els enllaços proporcionats.
```
a19pabmatpav@inspedralbes.cat

```
