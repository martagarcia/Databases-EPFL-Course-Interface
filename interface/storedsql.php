<?php
$storedSQL=array();

$storedSQL[0] = array("test1", "SELECT * FROM person, biography WHERE person.PersonName = biography.id LIMIT 0,10;");
$storedSQL[1] = array("a) Given an actor, compute his most productive year.", "SELECT * FROM person, biography WHERE person.PersonName = biography.id LIMIT 0,10;");
/*

a) Given an actor, compute his most productive year.</option>
b) Compute the number of movies per year per language.
c) Compute the evolution of the average duration of a movie (per year, per language).
d) Compute who worked with spouses/children/potential relatives.
e) Compute the evolution of genres of movies (per year/language/location)
f) Compute the evolution of average number of actors per movie (per year)
g) Compute the most referenced/spoofed/versioned (and all other types) movies.
h) Compute the maximum and the averages number of marriages in showbiz (by birth year/gender)
i) Compute the frequency of marriages between actors that played in the same movie
j) Given two people compute the minimum number of links between two people.

k) Compute the average minimum number of links between two people. 

l) Compute the average rating per language.
m) Compute the average rating of an actor’s movies.
*/

?>