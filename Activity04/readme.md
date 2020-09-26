pragma solidity ^0.6.12;

contract Attestation {

    struct Patient {
        uint id;
        bool status;
        string name;
    }

    address public patient;

    struct Doctor {
        uint id;
        bool status;
        string name;
    }

    address public doctor;

    
    mapping(address => Patient) public patient;
    mapping(address => Patient) public patient;

    constructor() public {
    }

   function setPatient(address p ) public{
       patient = p;
    }

   function getPatient() public (address) {
      return patient;
    } 

    function setDoctor(address d ) public{
       doctor = d;
    }

   function getDoctor() public (address) {
      return doctor;
    } 
}


Linguagem de Preferencia - PHP
Lib - Github: https://github.com/digitaldonkey/ethereum-php
