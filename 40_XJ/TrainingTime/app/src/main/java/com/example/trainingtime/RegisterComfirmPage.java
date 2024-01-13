package com.example.trainingtime;

import androidx.appcompat.app.AppCompatActivity;

import android.annotation.SuppressLint;
import android.content.Intent;
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

import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;

public class RegisterComfirmPage extends AppCompatActivity {

    public static final String USERNAME = "com.TrainingTime.application.TrainingTime.EXTRA_USERNAME";
    public static final String USERNAME_KEY = "com.TrainingTime.application.TrainingTime.EXTRA_USERNAME_KEY";
    private TextView etSeat;
    private TextView etName;
    private TextView etPassword;
    //private TextView result ;
    private TextView etGakka;
    private TextView etGakunen;
    private TextView etId;
    private Button Register1, Return;


    final static String insertUrl ="http://tbsv.japanwest.cloudapp.azure.com/apps/RegisterFile.php";

    @SuppressLint("SetTextI18n")
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_register_comfirm_page);

        Intent intent = getIntent();
        final String UserName = intent.getStringExtra(RegisterPage.EXTRA_USERNAME);
        final String UserId = intent.getStringExtra(RegisterPage.EXTRA_USERID);
        final String Password = intent.getStringExtra(RegisterPage.EXTRA_PASSWORD);
        final String seat = intent.getStringExtra(RegisterPage.EXTRA_SEAT);
        final String Spinner1 = intent.getStringExtra(RegisterPage.EXTRA_SPINNER1);
        final String Spinner2 = intent.getStringExtra(RegisterPage.EXTRA_SPINNER2);



        etName = findViewById(R.id.TextView2);
        etSeat = findViewById(R.id.TextView5);
        etId = findViewById(R.id.textView6);
        etGakka = findViewById(R.id.TextView3);
        etGakunen = findViewById(R.id.TextView4);
         etPassword= findViewById(R.id.textView7);
        Register1 = findViewById(R.id.RegisButton);
        Return = findViewById(R.id.Return);



        //　show the textView in the box
        etName.setText("名前： " + UserName);
        etGakka.setText("学科： " + Spinner1);
        etGakunen.setText("学年: " + Spinner2);
        etSeat.setText("出席番号: " + seat);
        etId.setText("ユーザー名: " + UserId);
        etPassword.setText("パスワード: " + Password);


// データベースで登録するは以下のコードになる。


        Register1.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Registration();    //ボタンを押すと処理する
            }

        });

        Return.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View view){
                Intent intent = new Intent(RegisterComfirmPage.this, RegisterPage.class);
                startActivity(intent);
            }
        });

    }

    private void Registration() {

        //前ページにデータを取る。
        Intent intent = getIntent();
        final String username = intent.getStringExtra(RegisterPage.EXTRA_USERNAME);
        final String userid = intent.getStringExtra(RegisterPage.EXTRA_USERID);
        final String pass = intent.getStringExtra(RegisterPage.EXTRA_PASSWORD);
        final String seat = intent.getStringExtra(RegisterPage.EXTRA_SEAT);
        final String Spinner1 = intent.getStringExtra(RegisterPage.EXTRA_SPINNER1);
        final String Spinner2 = intent.getStringExtra(RegisterPage.EXTRA_SPINNER2);



        //データベースに接続する
        StringRequest stringRequest = new StringRequest(Request.Method.POST,
                insertUrl, new Response.Listener<String>() {
            public void onResponse(String response) {

                try{
                    JSONObject jsonObject = new JSONObject(response);
                    String success = jsonObject.getString("success");

                    // Successが１になると、登録を完了する

                    if(success.equals("1")){
                        Toast.makeText(RegisterComfirmPage.this,"登録を完了しました!",
                                Toast.LENGTH_SHORT).show();
                        Intent toy = new Intent(RegisterComfirmPage.this,RegisterSuccessPage.class);
                       toy.putExtra(USERNAME, username);
                        toy.putExtra(USERNAME_KEY, "Register");
                        startActivity(toy);

                    }else if(success.equals("2")){
                        Toast.makeText(RegisterComfirmPage.this,"このユーザーは２回以上登録できません。",
                                Toast.LENGTH_SHORT).show();

                    }else{
                        Toast.makeText(RegisterComfirmPage.this,"登録を失敗しました!",
                                Toast.LENGTH_SHORT).show();

                    }

                } catch (JSONException e) {
                    e.printStackTrace();
                    //エラーが発生したら、アプリの画面上に表示する
                    Toast.makeText(RegisterComfirmPage.this,"登録をエラーしました!"
                            + e.toString(),  Toast.LENGTH_SHORT).show();



                }

                System.out.println(response.toString());
            }

        }, new Response.ErrorListener() {

            @Override
            public void onErrorResponse(VolleyError error) {
                //エラーが発生したら、アプリの画面上に表示する
                Toast.makeText(RegisterComfirmPage.this,"登録をエラーしました!"
                        + error.toString(),  Toast.LENGTH_SHORT).show();

            }
        })

        {
            // Phpにデーターを送信するパラメタ
            //以下の変数はphpに受け取るの変数は必ず同じ

            @Override
            protected Map<String, String> getParams() throws AuthFailureError {
                Map<String,String> parameters  = new HashMap<String, String>();
                parameters.put("username",username);
                parameters.put("pass",pass);
                parameters.put("userid",userid);
                parameters.put("seat",seat);
                parameters.put("gakka",Spinner1);
                parameters.put("gakunen",Spinner2);

                return parameters;
            }
        };

        RequestQueue requestQueue = Volley.newRequestQueue(this);
        requestQueue.add(stringRequest);
    }
}