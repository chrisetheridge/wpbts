package com.peachtree.wpbapp.activity;

import android.os.Bundle;
import android.support.annotation.NonNull;
import android.support.design.widget.NavigationView;
import android.support.v4.view.GravityCompat;
import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.ActionBarDrawerToggle;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.view.MenuItem;
import android.widget.ListView;

import com.peachtree.wpbapp.R;
import com.peachtree.wpbapp.*;
import com.peachtree.wpbapp.entities.Event;
import com.peachtree.wpbapp.layout_Handlers.List_Adapter;

import java.util.Date;
import java.util.ArrayList;

public class Event_List_Activity extends AppCompatActivity
        implements NavigationView.OnNavigationItemSelectedListener {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.event_list_activity);
        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);

        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        ActionBarDrawerToggle toggle = new ActionBarDrawerToggle(
                this, drawer, toolbar, R.string.navigation_drawer_open, R.string.navigation_drawer_close);
        drawer.setDrawerListener(toggle);
        toggle.syncState();

        NavigationView navigationView = (NavigationView) findViewById(R.id.nav_view);
        navigationView.setNavigationItemSelectedListener(this);

		ArrayList events=getListData();
		ListView view = (ListView)findViewById(R.id.event_list);
		view.setAdapter(new List_Adapter(events, this));
	}

	private ArrayList getListData(){
		ArrayList<Event> results = new ArrayList<>();
		Event event = new Event(0,new Date(16,12,1),"Event1");
		results.add(event);
		event = new Event(1,new Date(16,12,2),"Event2");
		results.add(event);
		return results;
	}

    @Override
    public void onBackPressed() {
        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        if (drawer.isDrawerOpen(GravityCompat.START)) {
            drawer.closeDrawer(GravityCompat.START);
        } else {
            super.onBackPressed();
        }
    }

    @SuppressWarnings("StatementWithEmptyBody")
    @Override
    public boolean onNavigationItemSelected(MenuItem item) {
        // Handle navigation view item clicks here.
        int id = item.getItemId();

        switch (id){
			case R.id.nav_event_list:
				break;
			case R.id.nav_event_calender:
				break;
			case R.id.nav_event_map:
				break;
			case R.id.nav_clinics:
				break;
			case R.id.nav_about:
				break;
			case R.id.nav_logout:
				break;
			default:
				break;
        }

        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        drawer.closeDrawer(GravityCompat.START);
        return true;
    }
}