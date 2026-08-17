<!DOCTYPE html>

<html lang="fr">
<?php include 'head.php'; ?>
    
<body>
	<?php include 'navbar.php'; ?>

    <!-- SECTION ABOUT -->
    <section id="about" class="anchor light">

        <h1>Hello!</h1>

        <div class="row">
            <div class="col-sm-9" style="max-width: 1500px; text-align: justify;">
                <p>My name is Nelly Barret and I am <b>associate professor</b> at <a href="https://www.insa-lyon.fr/" target="_blank">INSA Lyon</a> and the <a href="https://projet.liris.cnrs.fr/drim/" target="_blank">DRIM team</a> of the <a href="https://liris.cnrs.fr/" target="_blank">LIRIS lab</a> since September 2025. I work on highly interesting and challenging fields, including heterogeneous data management, data integration, interoperability, data exploration, all possibly being AI- and/or LLM-flavoured. Dynamic and hard worker, I'm always ready to take on new challenges!</p>

				<p>Previously, I was a happy post-doctoral researcher in the <a href="https://www.deib.polimi.it/eng/home-page" target="_blank">DEIB department</a> of <a href="https://www.polimi.it/en" target="_blank">Politecnico di Milano</a> where I worked on the <a href="https://annabernasconi.faculty.polimi.it/our-better-project-funded-by-horizon-europe/" target="_blank">BETTER project</a>, which aims at building a network of 7 European cooperating hospitals, each providing <b>very heterogeneous data</b>. Before, I enjoyed being a PhD student at <a href="https://www.inria.fr/fr/centre-inria-saclay-ile-de-france" target="_blank">Inria Saclay</a>, under the supervision of Pr. <a href="https://pages.saclay.inria.fr/ioana.manolescu/" target="_blank">Ioana Manolescu</a> in the <a href="https://team.inria.fr/cedar/" target="_blank">CEDAR team</a>, a joint team between Inria Saclay and &Eacute;cole Polytechnique. My thesis was on <b>summarization and exploration of semi-structured datasets</b>. Before my PhD, I graduated from <a href="https://www.univ-lyon1.fr/en" target="_blank">Universit&eacute; Lyon 1</a> where I obtained my Master in Artificial Intelligence.</p> 

                <p></p>

                
                <p>
		            <i>Website last update: 15th April 2026</i><br/>
                    <i class="fa-solid fa-file-pdf my-icon-first"></i><a class="linkCollapse" href="./generate-cv/cv-short-nelly-barret.pdf" target="_blank">My short curriculum</a> <i id="link-cv-short">(last update: </i><br/> <!-- add date automatically-->
		            <i class="fa-solid fa-file-pdf my-icon-first"></i><a class="linkCollapse" href="./generate-cv/cv-long-nelly-barret.pdf" target="_blank">My long curriculum</a> <i id="link-cv-long">(last update: </i><br/> <!-- add date automatically-->
                    <i class="fa-solid fa-file-pdf my-icon-first"></i><a class="linkCollapse" href="docs/short-bio-nelly-barret-EN.txt" target="_blank">My short bio (EN)</a> <i>(last update: Sept. 2025)</i><br/>
                    <i class="fa-solid fa-file-pdf my-icon-first"></i><a class="linkCollapse" href="docs/short-bio-nelly-barret-FR.txt" target="_blank">My short bio (FR)</a> <i>(last update: Sept. 2025)</i>
                </p>
            </div>
            <div class="col-sm-3" style="vertical-align: top; text-align: center;">
                <img src="img/photo.jpg" class="img_home" style="border-radius: 5%; max-height: 300px;" alt="photo"/>
            </div>
        </div>

        <div class="row">
            <br/>
        </div>

        
        <div class="row">
            <div class="col-sm-6">
                <h2>Contact</h2>
                <ul>
                    <li>Email: <a href="mailto:nelly.barret@insa-lyon.fr" title="nelly.barret@polimi.it">nelly(dot)barret(at)insa-lyon(dot)fr</a></li>
                    <li>My <a href="https://www.linkedin.com/in/nelly-barret-03908711b" target="_blank"><i class="fa-brands fa-linkedin" style="color: RoyalBlue !important;"></i>LinkedIn page</a></li>
                    <li>My ORCID is <a href="https://orcid.org/0000-0002-3469-4149" target="_blank"><i class="fa-brands fa-orcid" style="color: YellowGreen !important;"></i>0000-0002-3469-4149</a></li>
                </ul>
                <br/>
                <h2>Latest news</h2>
                <ul>
                    <li><i class="fa-solid fa-marker my-icon-first""></i>05/11/2025: Check-out my updated website (full publication list, etc)! </li>
                    <li><i class="fa-solid fa-briefcase my-icon-first"></i>01/09/2025: I became associate professor at INSA Lyon and the LIRIS lab! </li>
                    <li><i class="fa-solid fa-award my-icon-first"></i>23/10/2024: I received the 2nd prize from the BDA community, awarding PhDs with significant contributions to the data management field! </li>
                    <li><i class="fa-solid fa-pizza-slice my-icon-first"></i>01/04/2024: New challenges ahead! I moved to Milano and I started a post-doctoral researcher contract. </li>
                    <li><i class="fa-solid fa-graduation-cap my-icon-first"></i>15/03/2024: Last day as a PhD student: I defended my thesis at Inria Saclay, surrounded by a nice jury, the CEDAR team and my family! </li>
                </ul>
            </div>
            <div class="col-sm-6" style="vertical-align: top; text-align: center;">
                <img src="img/word-cloud.png" class="img_home" style="max-width: 600px" alt="word cloud"/>
            </div>
        </div>
    </section>
</body>
</html>

<script> 
const date = new Date();
let day = date.getDate();
let month = date.getMonth() + 1;
let year = date.getFullYear();
let last_update = `${day}-${month}-${year}`;
console.log(last_update);
$("#link-cv-long").append(last_update + ")");
$("#link-cv-short").append(last_update + ")");
</script> 