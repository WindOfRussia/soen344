from flask import Flask, render_template
from flask import json
from flask_cors import CORS
from flaskext.mysql import MySQL
from flask import Flask, render_template, request
from flask import Flask, render_template, request, json
from flask_cors import CORS
from backend.mappers.AppointmentMapper import AppointmentMapper
from backend.mappers.CartMapper import CartMapper
import flask_login
import flask




app = Flask(__name__,
            static_folder="./dist/static",
            template_folder="./dist")
CORS(app)
app.config['MYSQL_DATABASE_USER'] = 'root'
app.config['MYSQL_DATABASE_PASSWORD'] = ''
app.config['MYSQL_DATABASE_DB'] = 'soen344'
app.config['MYSQL_DATABASE_HOST'] = 'localhost'
mysql = MySQL()
mysql.init_app(app)

CORS(app)
appointment_mapper = AppointmentMapper(app)
cart_mapper = CartMapper(app)

login_manager = flask_login.LoginManager()
login_manager.init_app(app)



@app.route('/', defaults={'path': ''})

@app.route('/<path:path>')
def catch_all(path):
    return render_template("index.html")

@app.route('/getAppointments', methods=['GET'])
def getAppointments():
        connection = mysql.connect()
        cursor = connection.cursor()
        res = cursor.execute("SELECT * from appointments")
        row_headers = [x[0] for x in cursor.description]  # this will extract row headers
        data = []
        for row in cursor.fetchall():
            data.append(dict(zip(row_headers, row)))
        cursor.close()
        if(res is None):
            return False
        else:
            return json.dumps(data)

@app.route('/addAppointment', methods=['POST'])
def add_appointment():
    print(request.json)
    return appointment_mapper.add_appointment(request.get_json())

@app.route('/getCart')
def get_cart():
   return cart_mapper.get_cart()

@app.route('/addToCart', methods=['POST'])
def add_to_cart():
   print(request.get_json())
   return cart_mapper.add_to_cart(request.get_json())


# login start
# # how to database...idk doing it later for now

users = {'foo@bar.tld': {'password':'secret'}}

class User(flask_login.UserMixin):
  pass


@login_manager.user_loader
def user_loader(code):
  if code not in users:
    return

  user = User()
  user.id = code
  return user


@login_manager.request_loader
def request_loader(request):
  code = request.form.get('code')
  if code not in users:
    return

  user = User()
  user.id = code

  # DO NOT ever store passwords in plaintext and always compare password
  # hashes using constant-time comparison!
  user.is_authenticated = request.form['password'] == users[code]['password']

  return user

@app.route('/login', methods=['GET', 'POST'])
def login():
    code = flask.request.form['code']
    temp1 = flask.request.form['password']
    temp2 = users[code]['password']
    if temp1 == temp2:
        user = User()
        user.id = code
        flask_login.login_user(user)
        return flask.redirect(flask.url_for('protected'))

    return 'Bad login'


@app.route('/protected')
@flask_login.login_required
def protected():
    return 'Logged in as: ' + flask_login.current_user.id

@app.route('/logout')
def logout():
    flask_login.logout_user()
    return 'Logged out'

@login_manager.unauthorized_handler
def unauthorized_handler():
    return 'Unauthorized'
