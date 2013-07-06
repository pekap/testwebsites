from django.shortcuts import render_to_response
from django.http import HttpResponse
from django.template import RequestContext,Context,loader

def index(request):
    return render_to_response('mainpage.html', context_instance=RequestContext(request))

def greetingpage(request):
    return render_to_response('greetingpage.html', context_instance=RequestContext(request))

def greetingpage_record(request):
    template_record=loader.get_template('record_block.html')
    context_record=Context({
    })
    return HttpResponse(template_record.render(context_record))

def greetingpage_invite(request):
    template_invite=loader.get_template('invite_block.html')
    context_invite=Context({
    })
    return HttpResponse(template_invite.render(context_invite))

def greetingpage_compose(request):
    template_compose=loader.get_template('compose_block.html')
    context_compose=Context({
    })
    return HttpResponse(template_compose.render(context_compose))

def greetingpage_start(request):
    template_start=loader.get_template('start_block.html')
    context_start=Context({
    })
    return HttpResponse(template_start.render(context_start))

