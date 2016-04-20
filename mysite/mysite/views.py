import django
from django.http import HttpResponse,HttpResponseRedirect
from django.shortcuts import render,redirect
from django.contrib.auth import authenticate, login, logout
from django.contrib.auth.decorators import login_required
from forms import DateForm
@login_required
def time(request):
    form = DateForm(request.POST)
    return render(request,'time.html',{'form':form})
@login_required
def base(request):
    return render(request,'base.html',{})
@login_required
def index(request):
    return render(request,'index.html',{})
def hello(request):
    return HttpResponse('php and mysql')
def user_login(request):
    #return render(request,'login.html',{})
    if request.method == 'POST':
        username = request.POST['username']
	password = request.POST['password']
	user = authenticate(username=username, password=password)
	if user:
	    if  user.is_active:
	        login(request,user)
		return HttpResponseRedirect('/')
	    else:
	        return HttpResponse("Your account is disabled.")
        else:
	    return HttpResponse('please enter the correct username and password')
    else:
        return render(request, 'login.html',{})
@login_required	
def user_logout(request):
    logout(request)
    return HttpResponseRedirect('/login/')






