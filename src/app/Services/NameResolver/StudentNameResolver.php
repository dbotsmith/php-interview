<?php

namespace Services\NameResolver;

class StudentNameResolver implements NameResolverInterface {

  /**
   * @var (\Models\Student[])[] $byCandidate   Hash of arrays of Student objects. Key is candidate displayName (e.g. John, or John S).
   */
  protected $byCandidate = array();

  /**
   * Sets displayName property of each Student in the given array.
   * 1. If there are no other students in the collection with the same first name, their display name should be just their first name.
   * 2. If there are multiple students in the collection with the same first name, their display name should be their first name followed by a space and their last initial (e.g. “John Smith” would resolve to “John S”).
   *
   * @param \Models\Student[] $students   Array of Student objects which will be modified. 
   */
  public function resolve($students) {
    $this->byCandidate = array();

    $this->applyDisplayNameGenerator('self::firstName', $students); 

    //Find collisions and apply firstNameLastInitial()
    foreach (array_keys($this->byCandidate) as $c1) { //Note byCandidate may be modified within loop
      $matches = $this->byCandidate[$c1];
      if (count($matches) > 1) {
        $this->byCandidate[$c1] = array(); //Take matches out of old location
        $this->applyDisplayNameGenerator('self::firstNameLastInitial', $matches); 
      }
    }
  }

  /**
   * Sets displayName property of each Student in the given array using the given callable. Also adds the student objects to this->byCandidate under the computed displayName.
   *
   * @param callable $generateDisplayName  Takes Student as parameter and returns a string to be used as a candidate displayName.
   * @param \Models\Student[] $students    Array of Student objects which will be modified. 
   */
  protected function applyDisplayNameGenerator(callable $generateDisplayName, $students) {
    foreach ($students as $student) {
      $candidate = call_user_func($generateDisplayName, $student);
      $this->byCandidate[$candidate][] = $student;
      $student->displayName = $candidate;
    }
  }

  /**
   * Returns Student->firstName to be used by applyDisplayNameGenerator()
   *
   * @param \Models\Student $student
   * @return string
   */
  protected function firstName($student) {
    return $student->firstName;
  }

  /**
   * Returns Student firstName space lastName (e.g. "John S") to be used by applyDisplayNameGenerator()
   *
   * @param \Models\Student $student
   * @return string
   */
  protected function firstNameLastInitial($student) {
    return "{$student->firstName} {$student->lastName[0]}";
  }

}