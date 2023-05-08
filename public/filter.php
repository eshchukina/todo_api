







$task = new \App\Task();
$task->setTitle('  title  ');
$task->setDescription('  description  ');

$taskInputFilter = new InputFilter();
$taskInputFilter->add('title', [new TrimFilter()]);
$taskInputFilter->add('title', [new UpperFilter()]);
$taskInputFilter->add('description', [new TrimFilter()]);

$taskInputFilter->filter($task);

echo '"'.$task->getTitle().'"';