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
    if  "Interesting".eql?(m.system.classify text) then 1 else 0 end
  end
  
end

dir = ClassifierHandler.create "testUser"
ClassifierHandler.addInteresting("here are some good words. I hope you love them", dir)
ClassifierHandler.addUninteresting("here are some bad words, I hate you", dir)
puts ClassifierHandler.classify("I hate bad words and you" ,dir)





