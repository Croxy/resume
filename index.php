<?php
$json_resume = file_get_contents('resume.json');
?>

<!DOCTYPE html>
<html>
<head>
<!-- 											Welcome to my resume! I hope you like it! 													  -->
<!-- The current iteration is a working prototype for a system I plan on building to help automate creating a resume online                   -->
<!-- This idea came about when I wanted to update my resume but use JSON. I found https://jsonresume.org/ and it gave me a good starting point-->
<!-- I modified the JSON Resume specification to fit my specific needs. Future iterations will likely adhere to specification more strictly.  -->
<!-- I make use of the Handlebars.js templating engine and moment.js libraries in this project currently.                                     -->
<!-- My futre plans are to move to a more full-featured front-end frame work (likely Vue.JS) for handling the templating.                     -->
<!-- I also plan to develop a back-end component where a user could elect to save the resume (and revision history).                          -->

<title>Ryan Cox Resume</title>

<!-- Set view port -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Load local style sheet -->
<link rel="stylesheet" type="text/css" href="css/style.css">

<!-- set favicon -->
<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
<link rel="icon" href="img/favicon.ico" type="image/x-icon">

<!-- load handlebars.js and moment.js libraries -->
<script type="text/javascript" src="inc/handlebars.min-v4.0.12.js"></script>
<script type="text/javascript" src="inc/moment-v2.22.2.js"></script>

<!-- load Font Awesome style sheet for awesome fonts -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

<!-- Handlebars template for resume html content -->
<script id="resume-template" type="text/x-handlebars-template">
	<div class="print-icon"><i class="fas fa-print" onclick="window.print();return false;"></i></div>
	<div id="resume">
		{{#resume.basics}}
		<!-- Header section with avatar and logo -->
		<div class="header">
			<div class="picture">
				<img alt="avatar" src="{{picture}}">
			</div>
			<div class="header-image">
				<img alt="logo" src="img/row.png"></img>
			</div>
		</div>
		<!-- Content of resume -->
		<div id="resume-content">
			<!-- side section of page -->
			<section class="side">
				<h2><i class="fas fa-address-card"></i> Contact</h2>
				<div class="contact">
					{{#if website}}
					<div class="contact-item">
						<i id="icon" class="fas fa-link"></i>
						<div class="link"><a href="{{website}}" target="_blank">{{website}}</a></div>
					</div>
					{{/if}}
					{{#if email}}
					<div class="contact-item">
						<i id="icon" class="fas fa-envelope"></i>
						<div class="link"><a href="mailto:tr.coxy@gmail.com" target="_top">{{email}}</a></div>
					</div>
					{{/if}}
					{{#if phone}}
					<div class="contact-item">
						<i id="icon" class="fas fa-phone"></i>
						<div class="link"><a href="tel:918-857-1080">{{phone}}</a></div>
					</div>
					{{/if}}
					{{#location}}
					<div class="contact-item">
						<i id="icon" class="fas fa-map-marker-alt"></i>
						<div class="link">
							{{#if address}}
							<div id="address">{{address}}</div>
							{{/if}}
						{{#if city}}
							{{#if region}}
						<div class="city">{{city}}, {{region}}</div>
							{{/if}}
						{{/if}}
						{{#if postalCode}}
							{{#if countryCode}}
						<div class="postalCode">{{postalCode}}, {{countryCode}}</div>
							{{/if}}
						{{/if}}
						</div>
					</div>
					{{/location}}
					{{#each profiles}}
					<div class="contact-item">
						<i id="icon" class="{{icon}}"></i>
						<div class="link"><a href="{{url}}" target="_blank">@{{username}}</a></div>
					</div>
					{{/each}}
				</div>
				{{/resume.basics}}
				{{#if resume.skills.length}}
				<section id="skills">
					<h2><i class="fas fa-code"></i> Skills</h2>
					{{#each resume.skills}}
						{{#if name}}
					<div class="name">{{name}}</div>
						{{/if}}
					<div class="item">
						<div class="skills-side"></div>
						<div class="item-content">
							{{#if level}}
							<div class="level"><em>{{level}}</em></div>
							{{/if}}
							{{#if keywords.length}}
							<div class="keywords">
								{{#each keywords}}<span class="skills">{{.}}</span>{{/each}}
							</div>
							{{/if}}
						</div>
					</div>
					{{/each}}
				</section>
				{{/if}}
				{{#if resume.interests.length}}
				<section id="interests-wide">
					<h2><i class="fas fa-brain"></i> Interests</h2>
					{{#each resume.interests}}
					{{#if name}}
					<div class="name">{{name}}</div>
					{{/if}}
					<div class="item">
						<div class="skills-side"></div>
						{{#if keywords.length}}
						<div class="item-content">
							<div class="keywords">
								{{#each keywords}}
								<span class="skills">{{.}}</span>
								{{/each}}
							</div>
						</div>
						{{/if}}
					</div>
					{{/each}}
				</section>
				{{/if}}
			</section>
			<!-- main content section of page -->
			<section class="main">
				{{#resume.basics}}
				<h2><i class="fas fa-user"></i> About</h2>
				{{#if summary}}
				<div class="summary">
					<p>{{summary}}</p>
				</div>
				{{/if}}
				{{/resume.basics}}
				{{#if resume.work.length}}
				<h2><i class="fas fa-pencil-ruler"></i> Work</h2>
				<section id="work">
					{{#each resume.work}}
					<div class="item">
						<div class="position">{{position}}, </div><div class="company"><a href="{{website}}" target="_blank">{{company}}</a></div>
						<div class="date-range">
							{{#if startDate}}
							<span class="startDate">{{formatDate startDate}}</span>
							{{/if}}
							{{#if endDate}}
							<span class="endDate"> - {{formatDate endDate}}</span>
							{{else}}
							<span class="endDate"> - Present</span>
							{{/if}}
						</div>
						{{#if summary}}
						<div class="summary">
							<p>{{summary}}</p>
						</div>
						{{/if}}
						{{#if highlights.length}}
						<ul class="highlights">
							{{#each highlights}}
							<li>{{.}}</li>
							{{/each}}
						</ul>
						{{/if}}
					</div>
					{{/each}}
				</section>
				{{/if}}
				{{#if resume.education.length}}
				<h2><i class="fas fa-graduation-cap"></i> Education</h2>
				<section id="education">
					{{#each resume.education}}
					<div class="item">
						<div class="position">{{studyType}}, </div><div class="company">{{institution}}</div>
						<div class="date-range">
							{{#if startDate}}
							<span class="startDate">{{formatDate startDate}}</span>
							{{/if}}
							{{#if endDate}}
							<span class="endDate"> - {{formatDate endDate}}</span>
							{{else}}
							<span class="endDate"> - Present</span>
							{{/if}}
						</div>
						<div class="area">Majors: {{area}}</div>
						<div class="summary"><p>{{description}}</p></div>
					</div>
					{{/each}}
				</section>
				{{/if}}
				{{#if resume.awards.length}}
				<h2><i class="fas fa-award"></i> Awards</h2>
				<section id="awards">
					{{#each resume.awards}}
					<div class="item">
						<div class="position">{{title}}, </div><div class="company">{{awarder}}</div>
						<div class="date">{{formatDate date}}</div>
						<div class="summary"><p>{{summary}}</p></div>
					</div>
					{{/each}}
				</section>
				{{/if}}
				{{#if resume.references.length}}
				<h2><i class="fas fa-user-tie"></i> References</h2>
				<section id="references">
					{{#each resume.references}}
					<div class="item">
						<div class="name">{{name}}</div>
						<div class="job">{{position}}</div>
						<div class="company">{{company}}</div>
						<div class="email">{{email}}</div>
						<div class="phone">{{phone}}</div>
					</div>
					{{/each}}
				</section>
				{{/if}}
				{{#if resume.interests.length}}
				<section id="interests-mobile">
					<h2><i class="fas fa-brain"></i> Interests</h2>
					{{#each resume.interests}}
					{{#if name}}
					<div class="name">{{name}}</div>
					{{/if}}
					<div class="item">
						<div class="skills-side"></div>
						{{#if keywords.length}}
						<div class="item-content">
							<div class="keywords">
								{{#each keywords}}
								<span class="skills">{{.}}</span>
								{{/each}}
							</div>
						</div>
						{{/if}}
					</div>
					{{/each}}
				</section>
				{{/if}}
			</section>
		</div>
	</div>
</script>

	<script type="text/javascript">
		/* resume.json file */
		var resume   = {resume: <?=$json_resume?> };

		/* Register date format helper with moment.js */
		Handlebars.registerHelper('formatDate', function(dateString) {
    	return new Handlebars.SafeString(
        moment(dateString).format("MMM Y")
		    );
		});

		/* Compile resume.json into html using handlebars.js */
		var source   = document.getElementById("resume-template").innerHTML;
		var template = Handlebars.compile(source);
		var html    = template(resume);

		/* Function to load compiled HTML into HTML body/ */
		function loadHtml(){
			document.getElementById('body').innerHTML = html;

		}

	</script>
</head>
<body id="body" onload="loadHtml();">
</body>
</html>