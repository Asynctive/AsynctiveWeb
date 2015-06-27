/*
 * Asynctive Contact Script
 * Author: Andy Deveaux
 */

function setEmailFields()
{
	// Remove "Loading..." texts
	setInnerHTML('support-email', '');
	setInnerHTML('andy-email', '');
	
	var email = getEmailString('support', 'asynctive', 'com');
	createAndInsertLink('mailto:' + email, email, 'support-email');
	
	email = getEmailString('andy', 'asynctive', 'com');
	createAndInsertLink('mailto:' + email, email, 'andy-email');
}

function createAndInsertLink(href, text, element_id)
{
	var element = document.getElementById(element_id);
	if (element != null)
	{
		var link = document.createElement('A');
		link.href = href;
		link.innerHTML = text;
		element.appendChild(link);
	}
}

// Generates an email string to evade spam bots
function getEmailString(name, domain, tld)
{
	return name + "@" + domain + "." + tld;
}

function setInnerHTML(element_id, value)
{
	var element = document.getElementById(element_id);
	if(element != null)
	{
		element.innerHTML = value;
	}
}
