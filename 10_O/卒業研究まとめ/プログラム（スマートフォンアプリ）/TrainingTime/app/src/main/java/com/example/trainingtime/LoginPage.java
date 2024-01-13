package com.example.trainingtime;

import androidx.appcompat.app.AppCompatActivity;

import android.annotation.SuppressLint;
import android.app.ProgressDialog;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
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

import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;

public class LoginPage extends AppCompatActivity {

    public static final String USERNAME_DB = "com.TrainingTime.application.TrainingTime.EXTRA_USERNAME_DB";
    public static final String USER_ID1 = "com.TrainingTime.application.TrainingTime.EXTRA_USER_ID1";
    public static final String USERNAME_KEY = "com.TrainingTime.application.TrainingTime.EXTRA_USERNAME_KEY";
    private EditText UserID, Password;
    private TextView TextView;
    private static String login_url = "http://tbsv.japanwest.cloudapp.azure.com/apps/LoginTest.php";
    private Button Login, Return;
    private ProgressBar loading;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login_page);

        UserID = findViewById(R.id.UserID);
        Password = findViewById(R.id.Password);
        Return = findViewById(R.id.Return);
        TextView = findViewById(R.id.TextView2);
        Login = findViewById(R.id.LoginButton);
        loading = findViewById(R.id.loading);

        Login.setOnClickListener(new View.OnClickListener(){

            @SuppressLint("SetTextI18n")
            @Override
            public void onClick(View view) {
                 String User_id = UserID.getText().toString().trim();
                 String User_Pass = Password.getText().toString().trim();

                if(!User_id.isEmpty() && !User_Pass.isEmpty()){
                    Login();
                    TextView.setText("");


                }else if(User_id.isEmpty() && User_Pass.isEmpty()){
                    TextView.setText("全てを入力してください！");

                }else if(User_Pass.isEmpty()){
                    TextView.setText("パスワードを入力してください！");

                }else {
                    TextView.setText("ユーザ名を入力してください！");
                }
            }
        });


        Return.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View view){
                Intent intent = new Intent(LoginPage.this, MainActivity.class);
                startActivity(intent);
            }
        });

    }

     private void Login() {

        final String U_id = UserID.getText().toString();
        final String U_pass = Password.getText().toString();

        final ProgressDialog progressDialog = new ProgressDialog(this);
        progressDialog.setMessage("Please Wait..");

        progressDialog.show();



        StringRequest stringRequest = new StringRequest(Request.Method.POST,login_url, new Response.Listener<String>(){
            @Override
            public void onResponse(String response) {
                try{
                    JSONObject jsonObject = new JSONObject(response);
                    String success = jsonObject.getString("success");
                    String User_Name = jsonObject.getString("username");
                    String User_Id = jsonObject.getString("userid");


                    if(success.equals("1")){
                        Toast.makeText(LoginPage.this,"ログインを完了しました!", Toast.LENGTH_SHORT).show();
                        Intent toy = new Intent(LoginPage.this,RegisterSuccessPage.class);
                        toy.putExtra(USERNAME_DB, User_Name);
                        toy.putExtra(USER_ID1, User_Id);
                        toy.putExtra(USERNAME_KEY, "Login");
                        startActivity(toy);

                    }else if(success.equals("2")){
                        Toast.makeText(LoginPage.this,"このようなユーザー名は持っていない",
                                Toast.LENGTH_SHORT).show();
                    }else{
                        Toast.makeText(LoginPage.this,"不正なパスワードで、再ログインしてください",
                                Toast.LENGTH_SHORT).show();
                    }

                } catch (JSONException e) {
                    e.printStackTrace();
                    progressDialog.dismiss();
                    Toast.makeText(LoginPage.this, "ログインを失敗しました!" + e.toString(), Toast.LENGTH_SHORT).show();
                }

            }
        },
                new Response.ErrorListener(){

                    @Override
                    public void onErrorResponse(VolleyError error) {

                        progressDialog.dismiss();
                        Toast.makeText(LoginPage.this, "ログインを失敗しました!" + error.toString(), Toast.LENGTH_SHORT).show();


                    }
                })
        {
            @Override
            protected Map<String, String> getParams() throws AuthFailureError {
                Map<String, String> parameters = new HashMap<String, String>();
                parameters.put("user_id", U_id);
                parameters.put("pass", U_pass);

                return parameters;
            }
        };

        RequestQueue requestQueue = Volley.newRequestQueue(this);
        requestQueue.add(stringRequest);

    }

}

