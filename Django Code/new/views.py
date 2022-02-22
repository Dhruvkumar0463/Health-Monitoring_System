from django.contrib import messages
from django.core.files.storage import FileSystemStorage
from django.shortcuts import render, redirect
from django.views.generic import TemplateView
from chartjs.views.lines import BaseLineChartView
import json
import smtplib, ssl
import requests
import math, random


#otp = 0
#check_email = ""



def index(request):
    return render(request, 'index.html')

def logout(request):
    for key in list(request.session.keys()):
        if not key.startswith("_"):  # skip keys set by the django system
            del request.session[key]
    return render(request, 'index.html')
def index2(request):
    return render(request, 'index2.html')

def index3(request):
    return render(request, 'index3.html')

def password(request):
    return render(request, 'password.html')




def admin1(request):
    return render(request, 'admin.html')



def adduser(request):
    if request.method == 'POST':
        name = request.POST.get("name")
        email = request.POST.get("email")
        password = request.POST.get("password")
        phone = request.POST.get("phone")
        address = request.POST.get("address")
        role = request.POST.get("role")
        gender = request.POST.get("gender")
        dob = request.POST.get("dob")
        pic = request.FILES['upload_image']

        url = "http://healthmonitoring.tech/authentication/signup1.php"
        if role == "2":
            hname = request.POST.get("hname")
            haddress = request.POST.get("haddress")
            params = {
                "email": email,
                "password": password,
                "phone": phone,
                "role": role,
                "name": name,
                "bday": dob,
                "address": address,
                "gender": gender,
                "hname" : hname,
                "haddress": haddress,
            }
        else:
            params = {
                "email": email,
                "password": password,
                "phone": phone,
                "role": role,
                "name": name,
                "bday": dob,
                "address": address,
                "gender": gender,
                "hname": "",
                "haddress": "",
            }


        files = [
            ('dp',pic)
        ]

        r2 = requests.post(url=url, data=params, files=files)
        print(r2.text)

        res = r2.json()
        ev = res['error']

        if not ev:
            messages.success(request, "user added successfully!!")
            return render(request, 'admin.html')
        else:
            pass
    else:
        pass

    return render(request, 'dashboard.html')

def dispaly(request):
    records = {}
    url = "http://healthmonitoring.tech/authentication/details.php"
    r1 = requests.post(url=url, data="this")

    data_res = r1.json()

    ev = data_res['error']
    records['data'] = data_res['details']
    #print(records)

    if ev:
        messages.error(request, data_res['message'])

    return render(request, 'display.html', records)

def modifystatus(request):
    if request.method == 'POST':
        records = {}
        params = {
            "l_id": request.POST.get("l_id"),
        }
        url = "http://healthmonitoring.tech/authentication/changestatus.php"
        r1 = requests.post(url=url, data=params)

        data_res = r1.json()

        ev = data_res['error']

        if ev:
            messages.error(request, data_res['message'])
            return checkstatus(request)
        else:
            messages.success(request, data_res['message'])
            return checkstatus(request)

    else:
        messages.error(request, "Please Select Option First")
        return checkstatus(request)

def checkstatus(request):
    records = {}
    url = "http://healthmonitoring.tech/authentication/displaystatus.php"
    r1 = requests.post(url=url, data="this")

    data_res = r1.json()

    ev = data_res['error']
    records['data'] = data_res['details']
    print(records)

    if ev:
        messages.error(request, data_res['message'])

    return render(request, 'displaystatus.html', records)

def mapping(request):
    if request.method == 'POST':
        records = {}
        params = {
            "d_id": request.POST.get("doc_id"),
            "p_id": request.POST.get("patient_id"),
        }
        url = "http://healthmonitoring.tech/authentication/doctorallocator.php"
        r1 = requests.post(url=url, data=params)

        data_res = r1.json()
        print(data_res)
        ev = data_res['error']


        if ev:
            messages.error(request, data_res['message'])
            return dashboard(request)
        else:
            messages.success(request, "Records Updated Successfully.")
            return dashboard(request)

    else:
        messages.error(request, "Please Select Option First")
        return dashboard(request)





def updaterecords1(request):
    if request.method == 'POST':
        records = {}
        name = request.POST.get("name")
        email = request.POST.get("email")
        phone = request.POST.get("phone")
        address = request.POST.get("address")
        gender = request.POST.get("gender")
        dob = request.POST.get("dob")
        role = request.POST.get("role")
        pic = request.FILES['upload_image']

        files = [
            ('dp', pic)
        ]

        url = "http://healthmonitoring.tech/authentication/updaterecords2.php"
        if role == "2":
            hname = request.POST.get("hname")
            haddress = request.POST.get("haddress")
            params = {
                "email": email,
                "phone": phone,
                "name": name,
                "dob": dob,
                "address": address,
                "gender": gender,
                "role" : role,
                "hname": hname,
                "haddress": haddress,
            }
        else:
            params = {
                "email": email,
                "phone": phone,
                "role": role,
                "name": name,
                "dob": dob,
                "address": address,
                "gender": gender,
                "hname": "",
                "haddress": "",
            }

        r2 = requests.post(url=url, data=params, files=files)
        print(r2.text)

        res = r2.json()
        ev = res['error']

        if not ev:
            messages.success(request, "user Modified successfully!!")
            return dispaly(request)

    else:
        messages.error(request, "Please Enter Correct Details..!!")
        return render(request, 'updaterecords.html')



def modify(request):
    if request.method == 'POST':
        records = {}
        params = {
            "l_id": request.POST.get("l_id"),
        }
        url = "http://healthmonitoring.tech/authentication/updaterecords.php"
        r1 = requests.post(url=url, data=params)

        data_res = r1.json()
        print(data_res)
        ev = data_res['error']



        if ev:
            messages.error("Please Select Valid Option..!!")
            return render(request, 'display.html')
        else:
            img = data_res['details']['display_pic']
            img = "https://healthmonitoring-tech.stackstaging.com/authentication/" + img
            records['img'] = img
            records['data'] = data_res['details']
            if data_res['details']['l_role'] == "2":
                records['doctor'] = data_res['doctor']
            return render(request, 'updaterecords.html',records)

    else:
        messages.error(request, "Please Select Option First")
        return render(request, 'display.html')







def ecg(request):
    records = {}
    url = "http://healthmonitoring.tech/authentication/ecgsensordata.php"
    r1 = requests.post(url=url, data="this")

    ecg_res = r1.json()

    ev = ecg_res['error']
    records['data'] = ecg_res
    #print(records)

    if ev:
        messages.error(request, ecg_res['message'])

    return render(request, 'ecg.html', records)
class LineChartJSONView_ecg1(BaseLineChartView):
    def get_labels(self):
        """Return 7 labels for the x-axis."""
        return datae1Date

    def get_providers(self):
        """Return names of datasets."""
        return ["ECG"]

    def get_data(self):
        """Return 3 datasets to plot."""

        return [datae1]

line_chart_json_ecg1 = LineChartJSONView_ecg1.as_view()


def ecg1(request):
   # url = "http://healthmonitoring.tech/authentication/oxygensensordata.php"
    url = "http://healthmonitoring.tech/authentication/ecgsensordata.php"
    records = {}
    params = {
        "name": request.session['name1'],
    }

    r1 = requests.post(url=url, data=params)

    ecg_res = r1.json()

    ev = ecg_res['error']
    records['data'] = ecg_res
    print(ecg_res['message'])

    global datae1
    datae1 = []
    global datae1Date
    datae1Date = []


    if not ev:
        for k in records['data']['ecg']:
            datae1.append(k['ecg_value'])
            datae1Date.append(k['added_time'])

    if ev:
        messages.error(request, ecg_res['message'])

    return render(request, 'ecg1.html', records)

class LineChartJSONView_ecg2(BaseLineChartView):
    def get_labels(self):
        """Return 7 labels for the x-axis."""
        return datae2Date

    def get_providers(self):
        """Return names of datasets."""
        return ["ECG"]

    def get_data(self):
        """Return 3 datasets to plot."""

        return [datae2]

line_chart_json_ecg2 = LineChartJSONView_ecg2.as_view()

def ecg2(request):
    if request.method == 'POST':
        records = {}
        name = request.POST.get("name")
        # url = "http://healthmonitoring.tech/authentication/oxygensensordata.php"
        url = "http://healthmonitoring.tech/authentication/ecgsensordata.php"
        params = {
            "name": name,

        }
        print("name::" , name)
        r1 = requests.post(url=url, data=params)

        ecg_res = r1.json()

        ev = ecg_res['error']
        records['data'] = ecg_res
        global datae2
        datae2 = []
        global datae2Date
        datae2Date = []
        if not ev:
            for k in records['data']['ecg']:
                datae2.append(k['ecg_value'])
                datae2Date.append(k['added_time'])

        if ev:
            messages.error(request, ecg_res['message'])

        return render(request, 'ecg2.html', records)
    else:
        records = {}
        name = request.POST.get("name")
        # url = "http://healthmonitoring.tech/authentication/oxygensensordata.php"
        url = "http://healthmonitoring.tech/authentication/ecgsensordata.php"
        list = request.session['nameList']
        params = {
            "name": list[0],

        }

        r1 = requests.post(url=url, data=params)

        ecg_res = r1.json()

        ev = ecg_res['error']
        records['data'] = ecg_res

        datae2 = []
        datae2Date = []
        if not ev:
            for k in records['data']['ecg']:
                datae2.append(k['ecg_value'])
                datae2Date.append(k['added_time'])

        if ev:
            messages.error(request, ecg_res['message'])

        return render(request, 'ecg2.html', records)



def pulseRate(request):
    records = {}
    url = "http://healthmonitoring.tech/authentication/pulsesensordata.php"
    r1 = requests.post(url=url, data="this")

    pulse_res = r1.json()

    ev = pulse_res['error']
    records['data'] = pulse_res
    print(records)

    if ev:
        messages.error(request, pulse_res['message'])

    return render(request, 'pulseRate.html', records)


class LineChartJSONView_prate1(BaseLineChartView):
    def get_labels(self):
        """Return 7 labels for the x-axis."""
        return datap1Date

    def get_providers(self):
        """Return names of datasets."""
        return ["PulseRate"]

    def get_data(self):
        """Return 3 datasets to plot."""

        return [datap1]

line_chart_json_prate1 = LineChartJSONView_prate1.as_view()

def pulseRate1(request):
    # url = "http://healthmonitoring.tech/authentication/oxygensensordata.php"
    url = "http://healthmonitoring.tech/authentication/pulsesensordata.php"
    records = {}
    params = {
        "name": request.session['name1'],
    }

    r1 = requests.post(url=url, data=params)

    pulse_res = r1.json()

    ev = pulse_res['error']
    records['data'] = pulse_res
    global datap1
    datap1 = []
    global datap1Date
    datap1Date = []
    if not ev:
        for k in records['data']['pulse']:
            datap1.append(k['pulse_value'])
            datap1Date.append(k['added_time'])

    if ev:
        messages.error(request, pulse_res['message'])

    return render(request, 'pulseRate1.html', records)

class LineChartJSONView_prate2(BaseLineChartView):
    def get_labels(self):
        """Return 7 labels for the x-axis."""
        return datap2Date

    def get_providers(self):
        """Return names of datasets."""
        return ["PulseRate"]

    def get_data(self):
        """Return 3 datasets to plot."""

        return [datap2]

line_chart_json_prate2 = LineChartJSONView_prate2.as_view()

def pulseRate2(request):
    if request.method == 'POST':
        records = {}
        name = request.POST.get("name")
        # url = "http://healthmonitoring.tech/authentication/oxygensensordata.php"
        url = "http://healthmonitoring.tech/authentication/pulsesensordata.php"
        params = {
            "name": name,

        }
        #print("name::" , name)
        r1 = requests.post(url=url, data=params)

        pulse_res = r1.json()

        ev = pulse_res['error']
        records['data'] = pulse_res
        global datap2
        datap2 = []
        global datap2Date
        datap2Date = []
        if not ev:
            for k in records['data']['pulse']:
                datap2.append(k['pulse_value'])
                datap2Date.append(k['added_time'])

        if ev:
            messages.error(request, pulse_res['message'])

        return render(request, 'pulseRate2.html', records)
    else:
        records = {}
        name = request.POST.get("name")
        # url = "http://healthmonitoring.tech/authentication/oxygensensordata.php"
        url = "http://healthmonitoring.tech/authentication/pulsesensordata.php"
        list = request.session['nameList']
        params = {
            "name": list[0],

        }

        r1 = requests.post(url=url, data=params)

        pulse_res = r1.json()

        ev = pulse_res['error']
        records['data'] = pulse_res
        datap2 = []
        datap2Date = []
        if not ev:
            for k in records['data']['pulse']:
                datap2.append(k['pulse_value'])
                datap2Date.append(k['added_time'])

        if ev:
            messages.error(request, pulse_res['message'])

        return render(request, 'pulseRate2.html', records)


def spO2(request):
    records = {}
    url = "http://healthmonitoring.tech/authentication/oxygensensordata.php"
    r1 = requests.post(url=url, data="this")

    spO2_res = r1.json()

    ev = spO2_res['error']
    records['data'] = spO2_res
    #print(records)

    if ev:
        messages.error(request, spO2_res['message'])

    return render(request, 'spO2.html', records)


class LineChartJSONViewSpo21(BaseLineChartView):
    def get_labels(self):
        """Return 7 labels for the x-axis."""
        return dataspo2Date

    def get_providers(self):
        """Return names of datasets."""
        return ["spo2"]

    def get_data(self):
        """Return 3 datasets to plot."""

        return [dataspo2]

line_chart_json_spo21 = LineChartJSONViewSpo21.as_view()


def spO21(request):
    url = "http://healthmonitoring.tech/authentication/oxygensensordata.php"
    records = {}
    params = {
        "name": request.session['name1'],
    }

    r1 = requests.post(url=url, data=params)

    spO2_res = r1.json()

    ev = spO2_res['error']
    records['data'] = spO2_res
    #print(r1.json())
    global dataspo2
    dataspo2 = []
    global dataspo2Date
    dataspo2Date = []
    if not ev:
        for k in records['data']['oxygen']:
            dataspo2.append(k['oxygen_value'])
            dataspo2Date.append(k['added_time'])
   # print(dataspo2Date)
    if ev:
        messages.error(request, spO2_res['message'])

    return render(request, 'spO21.html', records)

class LineChartJSONViewSpo22(BaseLineChartView):
    def get_labels(self):
        """Return 7 labels for the x-axis."""
        return dataspo22Date

    def get_providers(self):
        """Return names of datasets."""
        return ["spo2"]

    def get_data(self):
        """Return 3 datasets to plot."""

        return [dataspo22]



line_chart_json_spo22 = LineChartJSONViewSpo22.as_view()

def spO22(request):
    if request.method == 'POST':
        records = {}
        name = request.POST.get("name")
        url = "http://healthmonitoring.tech/authentication/oxygensensordata.php"
        params = {
            "name": name,

        }
        print("name::" , name)
        r1 = requests.post(url=url, data=params)

        spO2_res = r1.json()

        ev = spO2_res['error']
        
        records['data'] = spO2_res
        global dataspo22
        dataspo22 = []
        global dataspo22Date
        dataspo22Date = []
        if not ev:
            for k in records['data']['oxygen']:
                dataspo22.append(k['oxygen_value'])
                dataspo22Date.append(k['added_time'])
        #print(records)

        if ev:
            messages.error(request, spO2_res['message'])

        return render(request, 'spO22.html', records)
    else:
        records = {}
        name = request.POST.get("name")
        url = "http://healthmonitoring.tech/authentication/oxygensensordata.php"
        list = request.session['nameList']
        params = {
            "name": list[0],

        }

        r1 = requests.post(url=url, data=params)

        spO2_res = r1.json()

        ev = spO2_res['error']
        records['data'] = spO2_res
        dataspo22 = []
        dataspo22Date = []
        if not ev:
            for k in records['data']['oxygen']:
                dataspo22.append(k['oxygen_value'])
                dataspo22Date.append(k['added_time'])

        if ev:
            messages.error(request, spO2_res['message'])

        return render(request, 'spO22.html', records)



def temperature(request):
    records = {}
    url = "http://healthmonitoring.tech/authentication/temperaturesensordata.php"
    r1 = requests.post(url=url, data="this")

    temperature_res = r1.json()

    ev = temperature_res['error']
    records['data'] = temperature_res
    #print(records)

    if ev:
        messages.error(request, temperature_res['message'])

    return render(request, 'temperature.html', records)

class LineChartJSONView_temp1(BaseLineChartView):
    def get_labels(self):
        """Return 7 labels for the x-axis."""
        return datat1Date

    def get_providers(self):
        """Return names of datasets."""
        return ["Temperature"]

    def get_data(self):
        """Return 3 datasets to plot."""

        return [datat1]

line_chart_json_temp1 = LineChartJSONView_temp1.as_view()

def temperature1(request):
    #url = "http://healthmonitoring.tech/authentication/oxygensensordata.php"
    url = "http://healthmonitoring.tech/authentication/temperaturesensordata.php"
    records = {}
    params = {
        "name": request.session['name1'],
    }

    r1 = requests.post(url=url, data=params)

    temperature_res = r1.json()

    ev = temperature_res['error']
    records['data'] = temperature_res
    global datat1
    datat1 = []
    global datat1Date
    datat1Date = []
    if not ev:
        for k in records['data']['temp']:
            datat1.append(k['temp_value'])
            datat1Date.append(k['added_time'])

    if ev:
        messages.error(request, temperature_res['message'])

    return render(request, 'temperature1.html', records)

class LineChartJSONView_temp2(BaseLineChartView):
    def get_labels(self):
        """Return 7 labels for the x-axis."""
        return datat2Date

    def get_providers(self):
        """Return names of datasets."""
        return ["Temperature"]

    def get_data(self):
        """Return 3 datasets to plot."""

        return [datat2]

line_chart_json_temp2 = LineChartJSONView_temp2.as_view()

def temperature2(request):
    if request.method == 'POST':
        records = {}
        name = request.POST.get("name")
        #url = "http://healthmonitoring.tech/authentication/oxygensensordata.php"
        url = "http://healthmonitoring.tech/authentication/temperaturesensordata.php"
        params = {
            "name": name,

        }
        print("name::" , name)
        r1 = requests.post(url=url, data=params)

        temperature_res = r1.json()

        ev = temperature_res['error']
        records['data'] = temperature_res
        global datat2
        datat2 = []
        global datat2Date
        datat2Date = []
        if not ev:
            for k in records['data']['temp']:
                datat2.append(k['temp_value'])
                datat2Date.append(k['added_time'])

        if ev:
            messages.error(request, temperature_res['message'])

        return render(request, 'temperature2.html', records)
    else:
        records = {}
        name = request.POST.get("name")
        #url = "http://healthmonitoring.tech/authentication/oxygensensordata.php"
        url = "http://healthmonitoring.tech/authentication/temperaturesensordata.php"
        list = request.session['nameList']
        params = {
            "name": list[0],

        }

        r1 = requests.post(url=url, data=params)

        temperature_res = r1.json()
        datat2 = []
        datat2Date = []
        ev = temperature_res['error']
        records['data'] = temperature_res
        if not ev:
            for k in records['data']['temp']:
                datat2.append(k['temp_value'])
                datat2Date.append(k['added_time'])

        if ev:
            messages.error(request, temperature_res['message'])

        return render(request, 'temperature2.html', records)


def patientlist(request):
    records = {}
    url = "http://healthmonitoring.tech/authentication/patientlist.php"

    params = {
        "l_id": request.session['l_id'],

    }
    r2 = requests.post(url=url, data=params)
    res = r2.json()

    ev = res['error']
    records['data'] = res
    list1 = records['data']['details']
    name = []
    for lname1 in list1:
        for att,val in lname1.items():
            if att == "l_name":
                name.append(val)
    print(name)
    request.session['nameList'] = name

    if ev:
        messages.error(request, res['message'])
    return render(request, 'patientlist.html',records)

def dashboard(request):
    records = {}
    url_doctor = "http://healthmonitoring.tech/authentication/doctordetails.php"
    url_patient = "http://healthmonitoring.tech/authentication/patientdetails.php"
    r1 = requests.post(url=url_doctor, data="this")
    r2 = requests.post(url=url_patient, data="this")
    doc_res = r1.json()
    patient_res = r2.json()

    ev = doc_res['error']
    ev1 = patient_res['error']
    records['data'] = doc_res['doctor']
    records['data1'] = patient_res['patient']
    print(records)

    if ev:
        messages.error(request, "Unable to get ecords Try After Sometime...!")

    return render(request, 'dashboard.html', records)

def dashboard1(request):
    records = {}
    url = "http://healthmonitoring.tech/authentication/doctordetialsbyL_id.php"
    url2 = "http://healthmonitoring.tech/authentication/recent.php"
    params = {
        "l_id": request.session['l_id'],

    }
    r3 = requests.post(url=url, data=params)
    recent = requests.post(url=url2, data=params)
    res1 = r3.json()
    res2 = recent.json()
    ev = res1['error']
    ev1 = res2['error']
    if not ev and not ev1:
        request.session['doc_name'] = 'DR.' + res1['details']['l_name']
        request.session['doc_no'] = res1['details']['contact_no']
        docimg = res1['details']['display_pic']
        request.session['doc_pic'] = "https://healthmonitoring-tech.stackstaging.com/authentication/" + docimg

    if not ev1:
        records['data'] = res2
        print(records)
        #print(records['temp'])

    if ev:
        messages.error(request, "Unable to get Records Try After Sometime...!")
    if ev1:
        messages.error(request, res2['message'])

    return render(request, 'dashboard1.html',records)


def dashboard2(request):
    records1 = {}
    url = "http://healthmonitoring.tech/authentication/patientlist.php"
    url2 = "http://healthmonitoring.tech/authentication/warning.php"
    records = {}
    params = {
        "l_id": request.session['l_id'],

    }
    r4 = requests.post(url=url2, data=params)
    patient_list = requests.post(url=url, data=params)
    patient = patient_list.json()
    res2 = r4.json()
    ev2 = res2['error']

    #print(records['data'])

    if not ev2 :
        records['data'] = res2['details']
    ev = patient['error']
    if not ev:
        records1['data'] = patient
        list1 = records1['data']['details']
        name = []
        for lname1 in list1:
            for att, val in lname1.items():
                if att == "l_name":
                    name.append(val)

    request.session['nameList'] = name
    if ev2:
            messages.error(request, "Unable to get Records Try After Sometime...!")
    return render(request, 'dashboard2.html',records)

def checkuser(request):
    if request.method == 'POST':
        email = request.POST.get("txtemail")
        password = request.POST.get("txtpass")
        if(email == "" or password == ""):
            messages.error(request, "Please Enter Correct Details And Try Again..!! ")
            return render(request, 'index.html')

        records = {}
        url = "http://healthmonitoring.tech/authentication/login.php"
        params = {
            "email": email,
            "password": password
        }
        r2 = requests.post(url=url, data=params)
        print(r2.text)
        request.session['start'] = True
        res = r2.json()
        ev = res['error']
        if not ev:
            img = res['detail']['display_pic']
            img = "https://healthmonitoring-tech.stackstaging.com/authentication/" + img
            request.session['role'] = res['user']['l_role']
            status = res['user']['status']
            records['detail'] = res['detail']['l_name']
            gender = res['detail']['gender']
            request.session['l_id'] = res['user']['l_id']
            request.session['name1'] = res['detail']['l_name']
            request.session['img'] = img
            #print(status)

            if status == str("0"):
                messages.error(request, "Contact admin to Activate your account...! ")
            else:
                if request.session['role'] == str(0) :
                    if gender == "male":
                        request.session['name'] = 'MR.' + res['detail']['l_name']
                    else:
                        request.session['name'] = 'Miss.' + res['detail']['l_name']
                    return dashboard(request)
                elif request.session['role'] ==str(1):
                    if gender == "male":
                        request.session['name'] = 'MR.' + res['detail']['l_name']
                    else:
                        request.session['name'] = 'Miss.' + res['detail']['l_name']
                    return dashboard1(request)
                else:
                    request.session['name'] = 'DR.' + res['detail']['l_name']
                    return dashboard2(request)
        else:
            messages.error(request, "Invalid Email Or Password..!! ")

    else:
        if request.session['start'] :
            if request.session['role'] == str(0):
                return dashboard(request)
            elif request.session['role'] == str(1):
                return dashboard1(request)
            else:
                return dashboard2(request)
        else:
            messages.error(request, "Unable to Login..!!")

    return render(request, 'index.html')


def otpvalidate(request):
    if request.method == 'POST':
        otp1 = request.POST.get("otp")
        email = request.POST.get("txtemail")
        password = request.POST.get("txtpass")
        if otp1 == otp and check_email == email:
            url = "http://healthmonitoring.tech/authentication/changepassword.php"
            params = {
                "email": email,
                "password": password,

            }
            r2 = requests.post(url=url, data=params)
            print(r2.text)

            res = r2.json()
            ev = res['error']

            if not ev:

                return render(request, 'index.html')
            else:
                messages.error(request, "Invalid Email & Password !!")
        else:
            messages.error(request, "Enter Correct OTP or Email...!")

    else:

        messages.error(request, "Unable to Login..!!")

    return render(request, 'validate.html')


def checkuser1(request):
    if request.method == 'POST':
        email = request.POST.get("txtemail")

        url = "http://healthmonitoring.tech/authentication/resetemail.php"
        params = {
            "email": email,
        }
        r2 = requests.post(url=url, data=params)
        # print(r2.text)

        res = r2.json()
        ev = res['error']
        # print(res)
        print(res['details']['email_id'])
        global otp
        otp = generateOTP()
        global check_email
        check_email = res['details']['email_id']
        sendingMail( )
        if not ev:
            return render(request, 'validate.html', {"otp": otp, "email": check_email})
        else:
            messages.error(request, "Email Not Found!! ")
    else:

        messages.error(request, "Unable to Find Details..!!")

    return render(request, 'password.html')


def sendingMail( ):
    port = 587  # For starttls
    smtp_server = "smtp.stackmail.com"
    sender_email = "noreply@healthmonitoring.tech"
    receiver_email = check_email
    password1 = "health@123"
    message = """\
    Subject: OTP for password reset

    This message is sent by HEALTH MONITORING SYSTEM YOUR OTP IS:   """
    message += str(otp)

    context = ssl.create_default_context()
    with smtplib.SMTP(smtp_server, port) as server:
        server.ehlo()  # Can be omitted
        server.starttls(context=context)
        server.ehlo()  # Can be omitted
        server.login(sender_email, password1)
        server.sendmail(sender_email, receiver_email, message)


def generateOTP():
    # Declare a string variable
    # which stores all string
    string = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
    OTP = ""
    length = len(string)
    for i in range(6):
        OTP += string[math.floor(random.random() * length)]

    return OTP
