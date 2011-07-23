require 'net/http'
require 'uri'
require 'rubygems'
require 'nokogiri'
require 'open-uri'

module UrlToPlainText 

  # takes in a url and returns html data from the page 
  # with all tags removed and only text remaining
  def UrlToPlainText.getHTMLPage uri
    
    doc = Nokogiri::HTML open(uri).read
    doc.css('script').each { |node| node.remove }
    doc.css('link').each { |node| node.remove }
    doc.css('body').text.split("\n"). collect { |line| line.strip }.join("\n")
    doc.css('body').text.squeeze(" ").squeeze("\n")    
  end
  
  
  # Strips garbage : following words should be stripped
  # a, the, in, it, that, to, from, with, Mr., an, 
  def UrlToPlainText.stripGarbage(text, stopWordsFile)
    text = text.downcase
    text.delete '.', ',' , ':', '-'
    file = File.open(stopWordsFile, "r")
    contents = file.read
    stopWordsArray = contents.split
    textArray = text.split
    textArray - stopWordsArray
  end
  
  def UrlToPlainText.urlToWords uri
    text = UrlToPlainText.getHTMLPage uri
    UrlToPlainText.stripGarbage(text, "stopWords.txt").join(" ")
  end

end


