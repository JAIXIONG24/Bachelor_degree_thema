package com.example.trainingtime;

import androidx.appcompat.app.AppCompatActivity;
import androidx.core.app.ActivityCompat;
import androidx.core.content.ContextCompat;

import android.Manifest;
import android.annotation.SuppressLint;
import android.content.Context;
import android.content.Intent;

import android.content.pm.PackageManager;
import android.location.Address;
import android.location.Geocoder;
import android.location.Location;
import android.location.LocationListener;
import android.location.LocationManager;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.ProgressBar;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.google.zxing.integration.android.IntentIntegrator;
import com.google.zxing.integration.android.IntentResult;

import org.json.JSONException;
import org.json.JSONObject;

import java.math.RoundingMode;
import java.text.DecimalFormat;
import java.util.HashMap;
import java.util.List;
import java.util.Locale;
import java.util.Map;

public class RegisterSuccessPage extends AppCompatActivity implements LocationListener {
    final static String insertUrl ="http://tbsv.japanwest.cloudapp.azure.com/apps/get_location.php";
    final static String insert ="http://tbsv.japanwest.cloudapp.azure.com/apps/TrainingTimeRegis.php";

     static double gps_location_X, gps_location_Y;
     static String user_id, user_name;
     static String praid;
     static double get_location_X,get_location_Y;


    private Button register, Return;
    private Button User;
    private Button BarBtn;
    private TextView textView1, textView2, textView3 ;
    private ProgressBar loading;
    LocationManager locationManager;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_register_success_page);

        User = findViewById(R.id.UserName);
        BarBtn = findViewById(R.id.BarScen);
        Return = findViewById(R.id.Return);
        textView1 = findViewById(R.id.TextView10);
        textView2 = findViewById(R.id.TextView11);
        textView3 = findViewById(R.id.TextView13);
        loading = findViewById(R.id.loading);

        // 前のページから登録した名前をこのページに呼び出す
        Intent intent = getIntent();
        String UserName1 = intent.getStringExtra(RegisterComfirmPage.USERNAME);
        String key1 = intent.getStringExtra(RegisterComfirmPage.USERNAME_KEY);
        String UserName2 = intent.getStringExtra(LoginPage.USERNAME_DB);


        /*
        登録かログインかを判断して処理する
         */
        if(key1.equals("Register")){
            User.setText(UserName1);
            user_name = UserName1;
            user_id = intent.getStringExtra(RegisterPage.EXTRA_USERID);
        }else{
            User.setText(UserName2);
            user_name = UserName2;
            user_id = intent.getStringExtra(LoginPage.USER_ID1);

        }

            if (ContextCompat.checkSelfPermission(RegisterSuccessPage.this, Manifest.permission.ACCESS_FINE_LOCATION)
                != PackageManager.PERMISSION_GRANTED){
            ActivityCompat.requestPermissions(RegisterSuccessPage.this,new String[]{
                    Manifest.permission.ACCESS_FINE_LOCATION},1);

            return;
        }

        BarBtn.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View view){
                getLocation();

            }
        });


         Return.setOnClickListener(new View.OnClickListener(){
             @Override
             public void onClick(View view){
                 Intent intent = new Intent(RegisterSuccessPage.this, LoginPage.class);
                 startActivity(intent);
             }
         });

    }

    private void init(){
        register = findViewById(R.id.LogoutButton);

        register.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View v) {
                RegisterFile();
            }
        });

    }

    /*
    *
    携帯のGPSを使用させるコード
    *
     */

    @SuppressLint("MissingPermission")
    private void getLocation() {

        try {
            //Toast.makeText(RegisterSuccessPage.this,"少々お待ちください。位置情報を読み込む中です！", Toast.LENGTH_SHORT).show();
            locationManager = (LocationManager) getApplicationContext().getSystemService(Context.LOCATION_SERVICE);
            Toast.makeText(RegisterSuccessPage.this,"少々お待ちください。位置情報を読み込む中です！", Toast.LENGTH_SHORT).show();
            locationManager.requestLocationUpdates(LocationManager.GPS_PROVIDER,5,5,RegisterSuccessPage.this);
            Toast.makeText(RegisterSuccessPage.this,"少々お待ちください。位置情報を読み込む中です！", Toast.LENGTH_SHORT).show();

        }catch (Exception e){
            e.printStackTrace();
        }

    }

    @SuppressLint("SetTextI18n")
    @Override
    public void onLocationChanged(Location location) {
//        Toast.makeText(this, ""+location.getLatitude()+","+location.getLongitude(), Toast.LENGTH_SHORT).show();
        try {
            //Toast.makeText(RegisterSuccessPage.this,"少々お待ちください。位置情報を読み込む中です！", Toast.LENGTH_SHORT).show();
            Geocoder geocoder = new Geocoder(RegisterSuccessPage.this, Locale.getDefault());
            List<Address> addresses = geocoder.getFromLocation(location.getLatitude(),location.getLongitude(),1);
            gps_location_X = addresses.get(0).getLatitude();
            gps_location_Y = addresses.get(0).getLongitude();

            if(gps_location_X != 0 && gps_location_Y != 0){
                scanCode();

            }else{

                Toast.makeText(RegisterSuccessPage.this,"位置情報が読めない！", Toast.LENGTH_SHORT).show();
            }

        }catch (Exception e){
            e.printStackTrace();
        }

    }

    @Override
    public void onStatusChanged(String s, int i, Bundle bundle) {

    }

    @Override
    public void onProviderEnabled(String s) {

    }

    @Override
    public void onProviderDisabled(String s) {

    }

    /*
    *
    バーコードをスキャンするためなコード
    *
     */
    private void scanCode(){
        IntentIntegrator integrator = new IntentIntegrator(this);
        integrator.setCaptureActivity(CaptureAct.class);
        integrator.setOrientationLocked(false);
        integrator.setDesiredBarcodeFormats(IntentIntegrator.ALL_CODE_TYPES);
//        integrator.setPrompt("Scanning Code");
        integrator.setPrompt("");
        integrator.initiateScan();


    }

    @Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data ){
        IntentResult result = IntentIntegrator.parseActivityResult(requestCode, resultCode, data);
        if(result != null){

            /*:****************************/

            if(result.getContents() != null){
                praid = result.getContents();
                GetDataFromMysql();

            } else
                {
                Toast.makeText(this,"No Result", Toast.LENGTH_LONG).show();
            }
        }else{
            super.onActivityResult(requestCode, resultCode, data);

        }

    }


    private void GetDataFromMysql(){

        StringRequest stringRequest = new StringRequest(Request.Method.POST,
                insertUrl, new Response.Listener<String>() {
            @SuppressLint("SetTextI18n")
            public void onResponse(String response) {

                try{
                    JSONObject jsonObject = new JSONObject(response);
                    String praname = jsonObject.getString("praname");
                    String a = jsonObject.getString("praplace_x");
                    String b = jsonObject.getString("praplace_y");

                    get_location_X = Double.parseDouble(a);
                    get_location_Y = Double.parseDouble(b);

                    double x_a = get_location_X - gps_location_X;
                    double y_a = get_location_Y - gps_location_Y;

                    double x1 = Math.abs(x_a);
                    double y1 = Math.abs(y_a);

                    DecimalFormat df = new DecimalFormat("#.####");
                    df.setRoundingMode(RoundingMode.DOWN);
                    String x2 = df.format(x1);
                    String y2 = df.format(y1);

                    double x = Double.parseDouble(x2);
                    double y = Double.parseDouble(y2);

//                    Toast.makeText(RegisterSuccessPage.this,"X = "+ x +" Y = "+ y, Toast.LENGTH_SHORT).show();

                    if(x <= 0.0002 && y <= 0.0002){
                        textView1.setText("名前： " + user_name);
                        textView2.setText("ユーザー名： " + user_id);
                        textView3.setText("実習名： " + praname);
                        init();


                    }else{
                        Toast.makeText(RegisterSuccessPage.this,"位置情報が正しくない！", Toast.LENGTH_SHORT).show();
                        scanCode();

                    }

                } catch (JSONException e) {
                    e.printStackTrace();
                    Toast.makeText(RegisterSuccessPage.this,"登録をエラーしました!" + e.toString(),  Toast.LENGTH_SHORT).show();

                }

                System.out.println(response.toString());
            }

        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Toast.makeText(RegisterSuccessPage.this,"登録をエラーしました!" + error.toString(),  Toast.LENGTH_SHORT).show();
            }
        })

        {
            // Phpにデーターを送信するパラメタ
            //以下の変数はphpに受け取るの変数は必ず同じ

            @Override
            protected Map<String, String> getParams() throws AuthFailureError {
                Map<String,String> parameters  = new HashMap<String, String>();
                parameters.put("praid",praid);

                return parameters;
            }
        };

        RequestQueue requestQueue = Volley.newRequestQueue(this);
        requestQueue.add(stringRequest);

    }

    private void RegisterFile(){
        //データベースに接続する
        StringRequest stringRequest = new StringRequest(Request.Method.POST,
                insert, new Response.Listener<String>() {
            public void onResponse(String response) {

                try{
                    JSONObject jsonObject = new JSONObject(response);
                    String success = jsonObject.getString("success");

                    // Successが１になると、登録を完了する

                    if(success.equals("1")){
                        Toast.makeText(RegisterSuccessPage.this,"登録を完了しました!", Toast.LENGTH_SHORT).show();
                        gps_location_X = 0;
                        gps_location_Y = 0;
                        reStart();

                    }

                } catch (JSONException e) {
                    e.printStackTrace();
                    //エラーが発生したら、アプリの画面上に表示する
                    Toast.makeText(RegisterSuccessPage.this,"登録をエラーしました!" + e.toString(),  Toast.LENGTH_SHORT).show();
                    //loading.setVisibility(View.GONE);
                   // RegisterButton.setVisibility(View.VISIBLE);


                }

                System.out.println(response.toString());
            }

        }, new Response.ErrorListener() {

            @Override
            public void onErrorResponse(VolleyError error) {
                //エラーが発生したら、アプリの画面上に表示する
                Toast.makeText(RegisterSuccessPage.this,"登録をエラーしました!" + error.toString(),  Toast.LENGTH_SHORT).show();
                //loading.setVisibility(View.GONE);

            }
        })

        {
            // Phpにデーターを送信するパラメタ
            //以下の変数はphpに受け取るの変数は必ず同じ

            @Override
            protected Map<String, String> getParams() throws AuthFailureError {
                Map<String,String> parameters  = new HashMap<String, String>();
                parameters.put("userid",user_id);
                parameters.put("graid",praid);

                return parameters;
            }
        };

        RequestQueue requestQueue = Volley.newRequestQueue(this);
        requestQueue.add(stringRequest);

    }

    private void reStart(){
        Intent intent = getIntent();
        finish();
        startActivity(intent);

    }


}
