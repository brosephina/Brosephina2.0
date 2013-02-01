Brosephina2.0
=============
Krav k1: Installera från GitHub

Ladda ner

Du kan ladda ner Brosephina från github.
git klona git :/ / github.com/brosephina/Brosephina2.0.git
Du kan granska källan direkt på github: https://github.com/brosephina/Brosephina2.0

Installation

Först måste du göra data-katalogen skrivbar. Detta är platsen där Brosephina måste kunna skriva och skapa filer. 
CD brosephina, chmod 777 site / data
Andra måste du gå in i filen. htaccess och ändra koden ~ chpg11/DV1440/me/Brosephina2.0 till din egen root och där du sätter din Brosephina2.0
Senaste, har Brosephina några moduler som måste initieras. Du kan göra detta genom en styrenhet. Peka din webbläsare till följande länk. 
modul / install

Krav k3: Ett anpassningsbart ramverk

1. Ändra logo detta gör du genom att lägga in en logo/bild i Brosephina2.0/site/themes/mytheme och ändrar i filen Brosephina2.0/site/config.php. på den rad där det står 'logo' => 'logo_80x80.png' ändrar du logo_80x80.png' till det fil namnet du har på din bild. I samma array som heter data finner du även header och footer där du kan änder på titel och footer på webbplatsen.
Om du vill ändra något i navigerings menyn så ska du gå upp lite i samma fil och leta efter array my-navbar. där i kan du antingen lägga till en till flik eller ta bort någon befintlig.
2.För att skapa ett blogg inlägg så måste du vara inloggad. Det gör du genom att använda root som användar namn och root som lösenord, eller så skapar du en ny användare. Sedan kommer det upp en länk Create a News or blog. Tryck på den och fil i alla uppgifter som behövs. På type så väljer du att skriva in post och på key så väljer du att skriva news. Sedan är det bara att spara och det ska komma upp under rubriken News.
3. om du ska skapa en sida så är det bara att göra samma sak som det tidigare steget fast på type väljer du att skriva page och på key about. Sedan kan du kolla på den genom att trycka på About us i navigeringsmenyn.
