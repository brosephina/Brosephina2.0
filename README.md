Brosephina2.0
=============
<h4>Ladda ner</h4>
Du kan ladda ner Brosephina2.0 från GitHub. det gör du med hjälp av följande komando:<br/>
<i>git clone git://github.com/brosephina/Brosephina2.0.git</i><br/>
Du kan kolla på källkoden på GitHub via länken <a href='https://github.com/brosephina/Brosephina2.0'>GitHub</a><br/>
Nu kan du börja med installationen<br/>
<h4>Installation</h4>
<p><b>Först:</b> måste du göra data-katalogen skrivbar. Detta är platsen där Brosephina måste kunna skriva och skapa filer. 
Det gör du med hjälp desssa komandon:<br/>
<i>cd brosephina<br/>
chmod 777 site/data</i><br/>
<b>Andra:</b> måste du gå in i filen .htaccess och ändra koden ~chpg11/DV1440/me/Brosephina2.0 till din egen root och där du sätter din Brosephina2.0<br/>
<b>Tredje:</b> har Brosephina några moduler som måste initieras. Du kan göra detta genom en styrenhet. Peka din webbläsare till din Brosephina2.0 och sedan tryck på länken som 
ser ut som den nedan. <br/>
<b>modul/install</b></p>
<h3>Krav k3: Ett anpassningsbart ramverk</h3>
<p>1. Ändra logo detta gör du genom att lägga in en logo/bild i Brosephina2.0/site/themes/mytheme och ändrar i filen Brosephina2.0/site/config.php. på den rad där det står  <b>'logo' => 'logo_80x80.png'</b> ändrar du <i> logo_80x80.png'</i> till det fil namnet du har på din bild. I samma array som heter data finner du även header och footer där du kan änder på titel och footer på webbplatsen.<br/> Om du vill ändra något i navigerings menyn så ska du gå upp lite i samma fil och leta efter array <b>my-navbar</b>. där i kan du antingen lägga till en till flik eller ta bort någon befintlig.<br/>

2. För att skapa ett blogg inlägg så måste du vara inloggad. Det gör du genom att använda root som användar namn och root som lösenord, eller så skapar du en ny användare. Sedan kommer det upp en länk Create a News or blog. Tryck på den och fil i alla uppgifter som behövs. På type så väljer du att skriva in post och på key så väljer du att skriva news. Sedan är det bara att spara och det ska komma upp under rubriken News.<br/>

3. om du ska skapa en sida så är det bara att göra samma sak som det tidigare steget fast på type väljer du att skriva page och på key about. Sedan kan du kolla på den genom att trycka på About us i navigeringsmenyn.</p>
<h3>Krav k5: Valfri (optionellt)</h3>
<p>När det kommer till detta krav så gjorde jag ett forum. Du kan testa det genom att klicka på Forum i navigeringsmenyn. Om du inte är inloggad så kan du bara kolla på vad som redan finns i forumet. Men om du är inloggad så kan du göra olika saker, som att skapa en ny kategori, tryck på add categry och välj vad den ska hetta. Sedan kan du skapa en ny tråd i den kategorin, välj vilket ämne det ska handla om och fortsätt. Sedan där i kan du skapa en komentar detta gör du genom att klicka på make new post, skriv din komantar och sedan fortsätt så kommer den sedan upp. </p>
<h3>Krav k6: Projektdokumentation</h3>
