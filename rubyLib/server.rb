require 'rubygems'
require 'sinatra'
require 'ClassifierHandler.rb'

set :port, 4567

post '/newUser' do 
  user = params[:username]
  ClassifierHandler.create user
end

post '/addInteresting' do
  url = params[:url]
  user = params[:username]
  ClassifierHandler.addInterestingUrl(url,user)
end

post '/addUninteresting' do
  url = params[:url]
  user = params[:username]
  ClassifierHandler.addUninterestingUrl(url,user)
end

post '/classify' do
  url = params[:url]
  user = params[:username]
  ClassifierHandler.classifyUrl(url,user)

end
