[![Build Status](https://travis-ci.org/ir0ny1/validator.svg?branch=master)](https://travis-ci.org/ir0ny1/validator)
#Validation Helper Written By Dave Richer
##For Course: CST8257 Web Application Development
###Release Date: October 17th 2015
###Version: 1.0.0

####Current Valid rules:
Rule | Description
-----|------------
required | Field is required
sameAs:property | Field is same has property
minLength:number | Field is at least number characters long
maxLength:number | Field is not longer then number characters long
equalTo:value | Field Equals Value
phoneNumber | Field is in (NNN) NNN-NNNN format
postalCode | Field is in A0A0A0 or A0A 0A0 format
emailAddress | Field is a valid email address
complexPassword | Field is a complex password with 1 capital, 1 lowercase, 1 numeric, 1 special character and a minimum of six characters long

####Example:
```php
$rules = [
    "name"  =>  "required:min:6"
];

$data = [
    "name"  =>  "Dave"
];

$val = new Validator($data, $rules);

$val->validate();

if (!val->valid()) {
    echo $val->validationMessageFor("name");
}
```
####Would Produce
Name must be at least six characters long

```
$val->validationSummary();
```
Will return an array of all validation messages