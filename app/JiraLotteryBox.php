<?php namespace App;

class JiraLotteryBox
{
    /**
     * Contains lottery tickets.
     * 
     * @todo should be an instance of App/LotteryBag 
     * @param array
     */
    protected $lotteryBag;

    /**
     * The jackpot number for this round.
     *
     * @var string
     */
    private $jackpotNumber;

    /**
     * @param array App\JiraTicket
     */
    public function __construct($jiraTickets = NULL)
    {
        $this->lotteryBag = $jiraTickets;

        // retrieve jackpot number from setting
        
    }

    /**
     * Put all candidate tickets.
     *
     * @todo prevent duplicate ticket.
     * @param array App\JiraTicket
     */
    public function putTickets(array $tickets)
    {
        $this->lotteryBag = $tickets;
    }

    /**
     * Set jackpot number.
     *
     * @param string $jackpotNumber
     * @return $this
     */
    public function setJackpotNumber($jackpotNumber)
    {
        $this->jackpotNumber = $jackpotNumber;
        return $this;
    }

    /**
     * Get lottery bag.
     *
     * @return array
     */
    public function getLotteryBag()
    {
        return $this->lotteryBag;
    }

    /**
     * Try match jackpot ticket.
     *
     * @param void
     * @return App\JiraTicket || NULL
     */
    public function matchJackpot() 
    {
        // match ticket id
        foreach($this->lotteryBag as $lottery)
        {
            if($lottery->ticket_id == $this->jackpotNumber) 
            {
                $lottery->setIsjackpotHitted()->save();
                return $lottery;
            }
        }

        return NULL;
    }

}