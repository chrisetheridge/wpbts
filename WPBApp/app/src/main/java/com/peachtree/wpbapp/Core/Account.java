package com.peachtree.wpbapp.Core;

/**
 * Created by chrisetheridge on 8/25/16.
 */
public class Account {

    private static String ACCOUNT_API_URL = "/api/account";

    // when creating an account object, we should try log that user in
    public Account(String email, String password) {
        LogIn(email, password);
    }

    public void LogIn(String email, String password) {}

    public void LogOut(String email) {}

    public void IsLoggedIn(String email) {}

    public void UpdateAccountDetails(String email) {}

    public void Register(String email) {}

}
