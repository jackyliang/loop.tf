#!/usr/bin/perl
# by Stephen Wetzel May 03 2015
#Requires cURL is installed

#Run this first to get a list of detailed pages for each class stored in crns.csv.
#Will do a search for courses that contain the letter 'a', then 'e' and so on.  It'll dump the detailed page url to a file and the script getClasses.pl can be used to go through them and get the course details.

use strict;
use warnings;
use List::MoreUtils qw(any uniq);

my $outFileName = "crns.csv";

#use autodie; #die on file not found
$|++; #autoflush disk buffer


#curl --header 'cookie: JSESSIONID=DAFD862E73D3B79F02A873681C5FADDF;' --data 'formids=term%2CcourseName%2CcrseNumb%2Ccrn&component=searchForm&page=Home&service=direct&session=T&submitmode=submit&submitname=&term=4&courseName=test&crseNumb=&crn=' -X POST https://duapp2.drexel.edu/webtms_du/app

my $url = "https://duapp2.drexel.edu/webtms_du/app";
my $sessionId = '2357A293F0608215F6D989A989D17BE1';
my $body=''; #response body
my $data='formids=term%2CcourseName%2CcrseNumb%2Ccrn&component=searchForm&page=Home&service=direct&session=T&submitmode=submit&submitname=&term=4&crseNumb=&crn=&courseName=';
#my $letter='test';

my @letters = ('a', 'e', 'i', 'o', 'u', 'y');

my @allUrls;



#get the JSESSIONID:
#X-Powered-By: Servlet 2.5; JBoss-5.0/JBossWeb-2.1
#Set-Cookie: JSESSIONID=4B8CFED15E5B0566D67F70FFB8F570D0; Path=/webtms_du; Secure
#Content-Type: text/html;charset=UTF-8



my $temp = `curl -s -D -  --data 'formids=term%2CcourseName%2CcrseNumb%2Ccrn&component=searchForm&page=Home&service=direct&submitmode=submit&submitname=&term=1&courseName=test&crseNumb=&crn=' -X POST https://duapp2.drexel.edu/webtms_du/app -o /dev/null`; #Note the lack of &session=T, that's important

$temp =~ m/Set-Cookie: JSESSIONID=([A-F0-9]{32})/ or die "Can't find JSESSIONID";
$sessionId = $1; #found the current session ID


foreach my $letter (@letters)
{
	print "\n\ncurl --header 'cookie: JSESSIONID=$sessionId;' --data '$data$letter' -X POST $url 2>/dev/null";

	$body = `curl --header 'cookie: JSESSIONID=$sessionId;' --data '$data$letter' -X POST $url 2>/dev/null`; #get response body from curl
	
	print "\nLetter: $letter";
	
	my @newUrls = ();
	
	while ($body =~ m/.+<a href="(\/webtms_du\/app.+;sp=0)".+/g)
	{
		my $crnUrl = $1;
		$crnUrl =~ s/&amp;/&/g;
		#print "\n\n$crnUrl";
		push @newUrls, $crnUrl;
	}
	
	print "\nNew URLs: ", scalar @newUrls;	
	my $oldSize = scalar @allUrls;
	@allUrls = uniq(@allUrls, @newUrls);
	my $addedSize = scalar @allUrls - $oldSize;
	print "\nAdded Urls: $addedSize";
}


open my $ofile, '>', $outFileName or die "Cannot open output file: $!";
foreach my $thisUrl (@allUrls)
{
	print $ofile "\n$thisUrl";
	
	
}


print "\nDone\n\n";
