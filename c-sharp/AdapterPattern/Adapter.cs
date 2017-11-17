using System;

namespace AdapterPattern
{
    interface IDuck
    {
        void Quack();
        void Fly();
    }

    interface ITurkey
    {
        void Gobble();
        void Fly();
    }

    class MallardDuck : IDuck
    {
        public void Quack() { Console.WriteLine("Quack"); }
        public void Fly() { Console.WriteLine("I'm flying"); }
    }

    class WildTurkey : ITurkey
    {
        public void Gobble() { Console.WriteLine("Gobble gobble"); }
        public void Fly() { Console.WriteLine("I'm flying a short distance"); }
    }

    class TurkeyAdapter : IDuck
    {
        private readonly ITurkey _turkey;
        public TurkeyAdapter(ITurkey t) { _turkey = t; }
        public void Quack() { _turkey.Gobble(); }
        public void Fly()
        {
            for (var i = 0; i < 5; i++)
            {
                _turkey.Fly();
            }
        }
    }

    class DuckAdapter : ITurkey
    {
        private readonly Random _rnd = new Random();
        private readonly IDuck _duck;
        public DuckAdapter(IDuck d) { _duck = d; }
        public void Gobble() { _duck.Quack(); }

        public void Fly()
        {
            if(_rnd.Next(4) == 0) _duck.Fly();
            else Console.WriteLine("I'll fly next time");
        }
    }

    class Program
    {
        public static void TestDuck(IDuck d)
        {
            d.Quack();
            d.Fly();
        }

        public static void TestTurkey(ITurkey t)
        {
            t.Gobble();
            t.Fly();
        }
        static void Main()
        {
            var duck = new MallardDuck();
            var turkey = new WildTurkey();
            var turkeyAdapter = new TurkeyAdapter(turkey);
            var duckAdapter = new DuckAdapter(duck);

            Console.WriteLine("The Turkey says...");
            turkey.Gobble();
            turkey.Fly();

            Console.WriteLine("\nThe Duck says...");
            TestDuck(duck);

            Console.WriteLine("\nThe Turkey says...");
            TestDuck(turkeyAdapter);

            Console.WriteLine("\nThe Duck says...");
            TestTurkey(duckAdapter);
        }
    }
}
