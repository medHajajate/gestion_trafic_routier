package com.med.el_haj.registerandlogin;

import android.Manifest;
import android.app.Fragment;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.graphics.Color;
import android.location.Criteria;
import android.location.Location;
import android.location.LocationManager;
import android.net.Uri;
import android.os.Build;
import android.support.v4.app.ActivityCompat;
import android.support.v4.app.FragmentActivity;
import android.os.Bundle;
import android.support.v4.content.ContextCompat;
import android.util.Log;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.google.android.gms.appindexing.Action;
import com.google.android.gms.appindexing.AppIndex;
import com.google.android.gms.common.ConnectionResult;
import com.google.android.gms.common.GooglePlayServicesUtil;
import com.google.android.gms.common.api.GoogleApiClient;
import com.google.android.gms.location.LocationListener;
import com.google.android.gms.location.LocationServices;
import com.google.android.gms.maps.CameraUpdateFactory;
import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.OnMapReadyCallback;
import com.google.android.gms.maps.SupportMapFragment;
import com.google.android.gms.maps.model.CameraPosition;
import com.google.android.gms.maps.model.Circle;
import com.google.android.gms.maps.model.CircleOptions;
import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.Marker;
import com.google.android.gms.maps.model.MarkerOptions;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;

public class MapsActivity extends FragmentActivity implements  OnMapReadyCallback{

    private GoogleMap mMap;
    private ProgressDialog pDialog;
    private String userId1;


    private static final String MYTAG = "MYTAG";

    // Request Code to ask the user for permission to view their current location (***).
    // Value 8bit (value <256)
    public static final int REQUEST_ID_ACCESS_COURSE_FINE_LOCATION = 100;
    private Location mLastLocation;
    private GoogleApiClient mGoogleApiClient;

    double latitude,longitude;
    double logitudeCercle,latitudeCercle;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_maps);
        SupportMapFragment mapFragment = (SupportMapFragment) getSupportFragmentManager()
                .findFragmentById(R.id.map);
        mapFragment.getMapAsync(this);

        pDialog = new ProgressDialog(this);
        pDialog.setCancelable(false);



        Intent intent = this.getIntent();

        String name1= intent.getStringExtra("userID");
      String cercle_lat= intent.getStringExtra("cercle_lat");
        String cercle_long= intent.getStringExtra("cercle_long");
        logitudeCercle=Double.parseDouble(cercle_long);
        latitudeCercle=Double.parseDouble(cercle_lat);


        String nam = "moha@";
        GPSTracker gpsTracker=new GPSTracker(this);
        if(gpsTracker.canGetLocation){

            latitude=gpsTracker.getLatitude();
            longitude=gpsTracker.getLongitude();

           // Toast.makeText(getApplicationContext(), String.valueOf(lat)+" "+String.valueOf(lon),Toast.LENGTH_LONG).show();

        }else{
            gpsTracker.showSettingsAlert();
        }
        Toast.makeText(this, "lah"+latitude+"long"+longitude+"userid"+name1, Toast.LENGTH_LONG).show();
        registerPosition(name1,longitude,latitude);
        Toast.makeText(this, "latCercle :"+cercle_lat+"longCercle :"+cercle_long, Toast.LENGTH_LONG).show();



        // Create Progress Bar.



    }



    public void onMapReady(GoogleMap googleMap) {
        mMap = googleMap;


        // Add a marker in Sydney and move the camera
        mMap.setMapType(GoogleMap.MAP_TYPE_NORMAL);
        mMap.getUiSettings().setZoomControlsEnabled(true);
        mMap.setMyLocationEnabled(true);

        Circle circle = mMap.addCircle(new CircleOptions()
                .center(new LatLng(latitudeCercle, logitudeCercle))
                .radius(100)
                .strokeColor(Color.RED));
                //.fillColor(Color.BLUE));






    }









  //  final  String name_login,final  String email_login,

    private void registerPosition(final  String name,
                                   final double longitude,final double latitude) {
        // Tag used to cancel the request
        String tag_string_req = "req_register";
        pDialog.setMessage("Registering ...");
        showDialog();



        StringRequest strReq = new StringRequest(Request.Method.POST,
                AppURLs.URL, new Response.Listener<String>() {

            @Override
            public void onResponse(String response) {

                hideDialog();

                try {
                    JSONObject jObj = new JSONObject(response);
                    boolean error = jObj.getBoolean("error");
                   //
                   // logitudeCercle = jObj.getString("logitudeCercle");
                    //latitudeCercle = jObj.getString("latitudeCercle");




                    if (!error) {

                        //Toast.makeText(getApplicationContext(), "latCercle :"+logitudeCercle+"longCercle :"+latitudeCercle, Toast.LENGTH_LONG).show();


                      /*  Intent intent = new Intent(
                                RegistrationActivity.this,
                                MainActivity.class);
                        startActivity(intent);
                        finish(); */
                    } else {
                        String errorMsg = jObj.getString("error_msg");
                        Toast.makeText(getApplicationContext(),
                                errorMsg, Toast.LENGTH_LONG).show();
                    }
                } catch (JSONException e) {
                    e.printStackTrace();
                }

            }
        }, new Response.ErrorListener() {

            @Override
            public void onErrorResponse(VolleyError error) {
                Toast.makeText(getApplicationContext(),
                        error.getMessage(), Toast.LENGTH_LONG).show();
                hideDialog();
            }
        }) {

            @Override
            protected Map<String, String> getParams() {
                // Posting params to register url
                Map<String, String> params = new HashMap<String, String>();
                params.put("tag", "position");
                params.put("email", name);
                //params.put("name_login", name_login);
               // params.put("email_login", email_login);
                params.put("longitude", String.valueOf(longitude));
                params.put("latitude", String.valueOf(latitude));


                return params;
            }

        };


        AppController.getInstance().addToRequestQueue(strReq, tag_string_req);
    }


    private void showDialog() {
        if (!pDialog.isShowing())
            pDialog.show();
    }

    private void hideDialog() {
        if (pDialog.isShowing())
            pDialog.dismiss();
    }





}
