require 'rubygems'
require 'stemmer'
require 'classifier'
require 'htmlLib.rb'
require 'madeleine'


module ClassifierHandler 
  
  # takes in a name
  # returns a madeline object to make snapshots with a classifier
  def ClassifierHandler.create name
    m = SnapshotMadeleine.new(name) {
      Classifier::Bayes.new 'Interesting', 'Uninteresting'
    }
    m.take_snapshot 
    logfile = File.new("ClassifierLog.txt", "a")
    logfile.write("Madeleine should have just created a folder called " + name + " \n")
    name
  end
  
  def ClassifierHandler.addUninteresting(text, name)
    m = SnapshotMadeleine.new name
    m.system.train_uninteresting text
    m.take_snapshot
    name
  end 

  def ClassifierHandler.addInteresting(text, name)
    m = SnapshotMadeleine.new name
    m.system.train_interesting text
    m.take_snapshot
    name
  end

  def ClassifierHandler.classify(text, name)
    m = SnapshotMadeleine.new name
    if  "Interesting".eql?(m.system.classify text) then "true" else "false" end
  end


  def ClassifierHandler.addInterestingUrl(url,name)
    text = UrlToPlainText.urlToWords url
    ClassifierHandler.addInteresting(text, name)
  end

  def ClassifierHandler.addUninterestingUrl(url, name)
    text = UrlToPlainText.urlToWords url
    ClassifierHandler.addUninteresting(text, name)
  end

  def ClassifierHandler.classifyUrl(url, name)
    text = UrlToPlainText.urlToWords url
    ClassifierHandler.classify(text, name)
  end
  
end




