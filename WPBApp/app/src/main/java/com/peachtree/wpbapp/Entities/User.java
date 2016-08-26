package com.peachtree.wpbapp.entities;

/**
 * Entity that models a User.
 */
public class User {

    private String firstName;
    private String lastName;
    private String email;
    private String address;
    private String hashedPassword;
    private String status;

    public String getFirstName() {
        return this.firstName;
    }

    public String getLastName() {
        return this.lastName;
    }

    public String getEmail() {
        return this.email;
    }

    public String getAddress() {
        return this.address;
    }

    public String getHashedPassword() {
        return this.hashedPassword;
    }

    public String currentStatus() {
        return this.status;
    }

}
