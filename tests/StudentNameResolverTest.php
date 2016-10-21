<?php

use \PHPUnit\Framework\TestCase;
use \Models\Student;
use \Services\NameResolver\StudentNameResolver;

class StudentNameResolverTest extends TestCase {

	public function testNoDuplicateFirstNames() {

		// Arrange
		$students = array(
			new Student(1, 'Carrie', 'Fisher'),
			new Student(2, 'Harrison', 'Ford'),
			new Student(3, 'Mark', 'Hamill')
		);
		$resolver = new StudentNameResolver();

		// Act
		$resolver->resolve($students);
		$displayNames = array_map(function($student) {
			return $student->displayName;
		}, $students);

		// Assert
		$this->assertEquals(['Carrie', 'Harrison', 'Mark'], $displayNames);
	}

	public function testWithDuplicateFirstNames() {

		// Arrange
		$students = array(
			new Student(1, 'John', 'Smith'),
			new Student(2, 'John', 'Jones'),
			new Student(3, 'John', 'Doe'),
			new Student(4, 'Jane', 'Doe'),
		);
		$resolver = new StudentNameResolver();

		// Act
		$resolver->resolve($students);
		$displayNames = array_map(function($student) {
			return $student->displayName;
		}, $students);

		// Assert
		$this->assertEquals(['John S', 'John J', 'John D', 'Jane'], $displayNames);
	}

	public function testListWithOneName() {

		// Arrange
		$students = array(
			new Student(1, 'John', 'Smith'),
		);
		$resolver = new StudentNameResolver();

		// Act
		$resolver->resolve($students);
		$displayNames = array_map(function($student) {
			return $student->displayName;
		}, $students);

		// Assert
		$this->assertEquals(['John'], $displayNames);
	}

	public function testWithFirstNameLastInitialCollision() {

		// Arrange
		$students = array(
			new Student(1, 'John', 'Smith'),
			new Student(2, 'John', 'Jones'),
			new Student(3, 'John', 'Jacob Jingleheimer Schmidt'),
			new Student(4, 'Jane', 'Doe'),
		);
		$resolver = new StudentNameResolver();

		// Act
		$resolver->resolve($students);
		$displayNames = array_map(function($student) {
			return $student->displayName;
		}, $students);

		// Assert
		$this->assertEquals(['John S', 'John J', 'John What Now?', 'Jane'], $displayNames);
	}

}